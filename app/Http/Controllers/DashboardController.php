<?php

namespace App\Http\Controllers;

use App\Models\VoluntaryAction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Filtros opcionais
        $searchDate = $request->input('search_date');
        $searchCategory = $request->input('category');

        // Inicia a query base
        $query = VoluntaryAction::query()
            ->where('status', '!=', 'canceled')
            ->where('event_datetime', '>=', now()); // Só mostra ações futuras

        // Filtro por data (se o usuário selecionar)
        if ($searchDate) {
            $query->whereDate('event_datetime', $searchDate);
        }

        // Filtro por categoria (se quiser incluir)
        if ($searchCategory) {
            $query->where('category', $searchCategory);
        }

        // Ordenação: ações mais próximas primeiro
        $actions = $query->orderBy('event_datetime', 'asc')->get();

        return view('app.dashboard', compact('actions', 'searchDate', 'searchCategory'));
    }
}