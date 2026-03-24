<?php

namespace App\Http\Controllers;

use App\Http\Requests\OngRequest;
use App\Models\Ong;
use App\Models\User;
use App\Enums\OngStatus;
use App\Enums\Role;
use Illuminate\Support\Facades\Hash;
use App\Mail\OngApprovedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OngController extends Controller
{
    public function index()
    {
        $ongs = Ong::orderBy('name')->paginate(10);
        return view('app.ongs.index', compact('ongs'));
    }

    public function create()
    {
        return view('app.ongs.create');
    }

    public function store(OngRequest $request)

{
    $data = $request->validated();
    
    // Cria o usuário
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => Role::Ong->value,
    ]);

    // Remove a formatação do CNPJ para armazenar apenas números
    $cnpjLimpo = preg_replace('/[^0-9]/', '', $data['cnpj']);

    // Cria a ONG com status pending
    $ong = Ong::create([
        'name' => $data['name'],
        'cnpj' => $cnpjLimpo, // Armazena apenas números (14 dígitos)
        'email' => $data['email'],
        'phone' => $data['phone'],
        'address' => $data['address'],
        'description' => $data['description'],
        'user_id' => $user->id,
        'status' => OngStatus::Pending->value,
    ]);

    return redirect()->route('ongs.waiting');
}

    public function show(Ong $ong)
    {
        return view('app.ongs.show', compact('ong'));
    }

    // NOVO: Edição do perfil da ONG (para usuários ONG logados)
    public function editProfile()
    {
        // Busca a ONG do usuário logado
        $ong = Auth::user()->ong;
        
        if (!$ong) {
            abort(404, 'ONG não encontrada para este usuário.');
        }

        return view('app.ongs.edit-profile', compact('ong'));
    }

    // NOVO: Atualização do perfil da ONG
    public function updateProfile(Request $request)
    {
        $ong = Auth::user()->ong;
        
        if (!$ong) {
            abort(404, 'ONG não encontrada para este usuário.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:ongs,email,' . $ong->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:4096',
        ]);

        // Atualiza também o email do usuário
        Auth::user()->update(['email' => $data['email']]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('ongs', 'public');
        }

        $ong->update($data);

        return redirect()->route('profile.ong.edit')->with('success', 'Informações da ONG atualizadas com sucesso!');
    }

    // Método original para admin editar qualquer ONG (mantido)
    public function edit(Ong $ong)
    {
        $this->authorize('update', $ong);
        return view('app.ongs.edit', compact('ong'));
    }

    public function update(Request $request, Ong $ong)
    {
        $this->authorize('update', $ong);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:ongs,email,' . $ong->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('ongs', 'public');
        }

        $ong->update($data);

        return redirect()->route('ongs.edit', $ong)->with('success', 'Informações da ONG atualizadas com sucesso!');
    }

    public function destroy(Ong $ong)
    {
        $this->authorize('delete', $ong);
        $ong->delete();
        return redirect()->route('ongs.index')->with('success', 'ONG removida com sucesso.');
    }

    // ADMIN: Listar ONGs pendentes
    public function pending(Request $request)
    {
        if (auth()->user()->role !== Role::Admin) {
            abort(403, 'Acesso não autorizado.');
        }

        $query = Ong::where('status', OngStatus::Pending->value);

        // Aplicar filtros
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('cnpj')) {
            $query->where('cnpj', 'like', '%' . $request->cnpj . '%');
        }

        $ongs = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('app.admins-views.pending-ongs', compact('ongs'));
    }

    // ADMIN: Aprovar ONG (mantendo filtros)
    public function approve(Ong $ong, Request $request)
    {
        if (auth()->user()->role !== Role::Admin) {
            abort(403, 'Acesso não autorizado.');
        }

        $ong->update(['status' => OngStatus::Approved->value]);
        Mail::to($ong->email)->send(new OngApprovedMail($ong));

        // Manter os filtros após a ação
        return redirect()->route('ongs.pending', [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'cnpj' => $request->get('cnpj')
        ])->with('success', 'ONG aprovada com sucesso!');
    }

    // ADMIN: Rejeitar ONG (mantendo filtros)
    public function reject(Ong $ong, Request $request)
    {
        if (auth()->user()->role !== Role::Admin) {
            abort(403, 'Acesso não autorizado.');
        }

        $ong->update(['status' => OngStatus::Rejected->value]);

        // Manter os filtros após a ação
        return redirect()->route('ongs.pending', [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'cnpj' => $request->get('cnpj')
        ])->with('success', 'ONG rejeitada com sucesso!');
    }

    // Tela de espera
    public function waiting()
    {
        $user = auth()->user();
        if ($user && $user->role === 'ong') {
            $ong = Ong::where('user_id', $user->id)->first();
            if ($ong && $ong->status === OngStatus::Approved->value) {
                return view('app.ongs.waiting', [
                    'message' => 'Sua ONG foi aprovada! Você já pode fazer login normalmente.'
                ]);
            }
        }
        return view('app.ongs.waiting');
    }

    // Método para mostrar detalhes da ONG (admin)
public function showDetails(Ong $ong)
{
    // Apenas admin pode acessar
    if (!auth()->user()->hasRole(\App\Enums\Role::Admin)) {
        abort(403, 'Acesso não autorizado.');
    }

    // Carrega as relações necessárias
    $ong->load(['user.voluntaryActions.registrations']);

    return view('app.admins-views.ong-details', compact('ong'));
}
}