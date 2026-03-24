<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
        // Verifica permissão pela Policy
        $this->authorize('viewAny', User::class);

        $query = User::query();
    
        // Filtro por nome
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        
        // Filtro por email
        if ($request->has('email') && $request->email != '') {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        
        // Filtro por tipo (role) - CORRIGIDO: usa 'type' em vez de 'role'
        if ($request->has('type') && $request->type != '') {
            $query->where('role', $request->type);
        }
        
        $users = $query->get();
        
        return view('app.users.index', compact('users'));

    }

    public function create()
    {
        return view('app.register');
    }

    public function store(UserRequest $request)
    {
        // validação dos campos da request
        $data = $request->validated();

        // grava no banco de dados
        User::create($data);

        // redireciona em caso de sucesso
        return redirect()->route('user.create')->with('success', 'Cadastro realizado com sucesso! Faça login para acessar o sistema.');
    }

    public function edit()
    {
        $user = auth()->user();
        return view('app.users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|max:12|confirmed',
        ], [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome deve conter no máximo 255 caracteres.',
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O campo e-mail deve ser um endereço de e-mail válido.',
            'email.unique' => 'O e-mail já está cadastrado.',
            'password.string' => 'O campo senha deve ser uma string.',
            'password.min' => 'O campo senha deve conter no mínimo 6 caracteres.',
            'password.max' => 'O campo senha deve conter no máximo 12 caracteres.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('user.edit')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function destroy(User $user)
    {
    $this->authorize('delete', $user);

        try {
            $user->delete();
            return redirect()->route('users.index')
                ->with('success', 'Usuário excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('users.index')
                ->with('error', 'Erro ao excluir usuário: ' . $e->getMessage());
        }
    }
}