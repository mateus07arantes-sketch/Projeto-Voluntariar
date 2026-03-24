<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use App\Models\VoluntaryAction;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Registration::class, 'registration');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $filter = $request->get('filter');

        $query = $user->registrations()->with('voluntaryAction');

        // FILTRO "participou" - mostra apenas participated = true
        if ($filter === 'attended') {
            $query->where('participated', true);
        }

        // FILTRO "não participou" - mostra apenas participated = false
        if ($filter === 'not_participated') {
            $query->where('participated', false);
        }

        $registrations = $query->orderBy('registered_at', 'desc')->paginate(15);

        return view('app.registrations.index', compact('registrations'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(RegistrationRequest $request)
    {
        $this->authorize('create', Registration::class);
        
        $user = $request->user();
        $actionId = $request->input('voluntary_action_id');

        $action = VoluntaryAction::findOrFail($actionId);

        if ($action->computed_status !== \App\Enums\ActionStatus::Active) {
            return back()->with('error', 'Esta ação não está mais disponível para inscrições.');
        }

        $currentCount = $action->registrations()
            ->where('status', 'active')
            ->count();
            
        if ($action->vacancies > 0 && $currentCount >= $action->vacancies) {
            return back()->with('error', 'Não há vagas disponíveis para esta ação.');
        }

        //  Atualiza inscrição cancelada ou cria nova
        $registration = Registration::updateOrCreate(
            [
                'user_id' => $user->id,
                'voluntary_action_id' => $actionId
            ],
            [
                'participated' => false,
                'status' => 'active',
                'registered_at' => now()
            ]
        );

        // MENSAGEM DE CONFIRMAÇÃO ATUALIZADA
        return redirect()->back()->with('success', [
            'title' => 'Inscrição realizada com sucesso! ',
            'message' => 'Você se inscreveu na ação "' . $action->name . '". 
                        Você pode acompanhar e gerenciar suas inscrições na seção 
                        "Minhas Inscrições" do seu perfil.',
            'type' => 'registration_success'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Registration $registration)
    {
        $this->authorize('delete', $registration);

        //  NOVA REGRA: Não permite cancelar se ação já foi finalizada
        $action = $registration->voluntaryAction;
        
        if ($action->event_datetime && $action->event_datetime->isPast()) {
            return back()->with('error', 'Não é possível cancelar a inscrição após a ação ter sido realizada.');
        }

        $registration->update(['status' => 'cancelled']);

        return redirect()->back()->with('success', [
            'title' => 'Inscrição cancelada!',
            'message' => 'Sua inscrição na ação "' . $action->name . '" foi cancelada.',
            'type' => 'cancellation_success'
        ]);
    }

    /**
     * Marcar participação - CORRETO!
     */
    public function markParticipation(Request $request, Registration $registration)
    {
        $this->authorize('markParticipation', $registration);

        $participated = $request->input('participated') === '1';
        
        //  CORRETO: Só atualiza o campo participated, NÃO mexe no status
        $registration->update([
            'participated' => $participated
            // Status continua 'active' - só muda a participação
        ]);

        return redirect()->back()->with('success', 
            $participated 
                ? 'Participação confirmada!' 
                : 'Não participação registrada!'
        );
    }
}