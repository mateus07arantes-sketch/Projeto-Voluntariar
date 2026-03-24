<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoluntaryActionRequest;
use App\Models\VoluntaryAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Registration;

class VoluntaryActionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $query = VoluntaryAction::with(['user.ong', 'registrations']);

    // ⬇️ AGORA TODOS veem apenas ações ativas e futuras
    if (auth()->check()) {
        if (auth()->user()->hasRole(\App\Enums\Role::Admin)) {
            // Admin também vê apenas ações ativas (ao invés de tudo)
            $query->visibleToUsers();
        } elseif (auth()->user()->hasRole(\App\Enums\Role::Ong)) {
            // ONG vê apenas ações ativas de todas as ONGs (incluindo as próprias)
            $query->visibleToUsers();
        } else {
            // Usuário comum vê apenas ações ativas e futuras
            $query->visibleToUsers();
        }
    } else {
        // Visitante vê apenas ações ativas e futuras
        $query->visibleToUsers();
    }

    // Filtro por nome
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Filtro por categoria
    if ($request->filled('category')) {
        $query->category($request->category);
    }

    // Filtro por data
    if ($request->filled('date')) {
        $query->whereDate('event_datetime', $request->date);
    }

    $actions = $query->orderBy('event_datetime', 'asc')
                     ->paginate(12);

    return view('app.actions.index', compact('actions'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', VoluntaryAction::class);
        return view('app.actions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VoluntaryActionRequest $request)
    {
       $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('voluntary_actions', 'public');
        }

        $action = VoluntaryAction::create($data);

        return redirect()->route('actions.show', $action)->with('success', 'Ação voluntária criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(VoluntaryAction $action)
    {
        // Conta quantos voluntários estão inscritos na ação
        $registers = $action->registrations()
            ->where('status', 'active')
            ->count();

        // Carrega as relações necessárias
        $action->load('user.ong', 'registrations.user');

        // Verifica se o usuário atual está inscrito
        $isRegistered = false;
        if (auth()->check()) {
            $isRegistered = Registration::where('user_id', auth()->id())
                ->where('voluntary_action_id', $action->id)
                ->where('status', 'active')
                ->exists();
        }

        // Conta vagas ocupadas
        $occupiedVacancies = $registers;

        $availableVacancies = $action->vacancies - $occupiedVacancies;

        return view('app.actions.show', compact(
            'action',
            'registers',
            'isRegistered', 
            'availableVacancies',
            'occupiedVacancies'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(VoluntaryAction $action)
    {
        $this->authorize('update', $action);

        // ⬇️ NOVA REGRA: Não permite editar se ação já foi finalizada
        if ($action->event_datetime && $action->event_datetime->isPast()) {
            return back()->with('error', 'Não é possível editar a ação após ela ter sido realizada.');
        }

        return view('app.actions.edit', compact('action'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VoluntaryActionRequest $request, VoluntaryAction $action)
    {

    // DEBUG: Verificar se está passando pela autorização
    \Log::info('Tentativa de update', [
        'user_id' => auth()->id(),
        'user_role' => auth()->user()->role,
        'action_user_id' => $action->user_id,
        'action_id' => $action->id
    ]);

        $this->authorize('update', $action);

        // ⬇️ NOVA REGRA: Não permite atualizar se ação já foi finalizada
        if ($action->event_datetime && $action->event_datetime->isPast()) {
            return back()->with('error', 'Não é possível editar a ação após ela ter sido realizada.');
        }

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($action->image && Storage::disk('public')->exists($action->image)) {
                Storage::disk('public')->delete($action->image);
            }
            $data['image'] = $request->file('image')->store('voluntary_actions', 'public');
        }

        $action->update($data);

        return redirect()->route('actions.show', $action)->with('success', 'Ação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(VoluntaryAction $action)
    {
        $this->authorize('delete', $action);

        // Impede exclusão somente se houver inscrições ATIVAS
        if ($action->registrations()->where('status', 'active')->exists()) {
            return back()->with('error', 'Não é possível excluir ações enquanto houver inscrições ativas.');
        }

        if ($action->image && Storage::disk('public')->exists($action->image)) {
            Storage::disk('public')->delete($action->image);
        }

        $action->delete();

        return redirect()->route('actions.index')->with('success', 'Ação excluída com sucesso!');
    }

    public function ongHistory(Request $request)
    {
        if (!auth()->user()->hasRole(\App\Enums\Role::Ong)) {
            abort(403, 'Acesso permitido apenas para ONGs');
        }

        $query = VoluntaryAction::where('user_id', auth()->id())
            ->withCount(['registrations as active_registrations_count' => function($query) {
                $query->where('status', 'active');
            }]);

        // Filtros simples (nome e categoria)
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // ⬇️ FILTRO POR COMPUTED_STATUS (AQUI ESTÁ A SOLUÇÃO) ⬇️
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('status', 'active')
                    ->where('event_datetime', '>=', now());
            } elseif ($request->status === 'finished') {
                $query->where(function($q) {
                    $q->where('status', 'finished')
                    ->orWhere(function($subQ) {
                        $subQ->where('status', 'active')
                            ->where('event_datetime', '<', now());
                    });
                });
            } else {
                // Para cancelled, edited, etc - usa status real
                $query->where('status', $request->status);
            }
        }

        $actions = $query->orderBy('event_datetime', 'desc')
                        ->paginate(15)
                        ->withQueryString();

        return view('app.actions.ong_history', compact('actions'));
    }
}
