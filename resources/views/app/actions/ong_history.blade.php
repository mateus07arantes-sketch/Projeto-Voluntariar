@extends('app.layouts.template')

@section('title', 'Minhas Ações')

@section('content')
<div class="container-fluid px-4 mt-4 p-5">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1" style="color: var(--text-dark);">Minhas Ações</h1>
                    <p class="text-muted mb-0">Gerencie todas as ações criadas pela sua organização</p>
                </div>
                <a href="{{ route('actions.index') }}" class="btn btn-outline-primary rounded-2 fw-semibold">
                    <i class="fas fa-arrow-left me-2"></i>Voltar para Ações
                </a>
            </div>
        </div>
    </div>

    <!-- Mensagens -->
    @if (session('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- FILTROS -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <form method="GET" action="{{ route('actions.ong.history') }}" class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">Nome da Ação</label>
                            <input type="text" name="search" class="form-control rounded-2" placeholder="Buscar por nome" value="{{ request('search') }}">
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">Categoria</label>
                            <select name="category" class="form-select rounded-2">
                                <option value="">Todas as categorias</option>
                                <option value="environmental" {{ request('category') == 'environmental' ? 'selected' : '' }}>Ambiental</option>
                                <option value="social" {{ request('category') == 'social' ? 'selected' : '' }}>Social</option>
                                <option value="animal" {{ request('category') == 'animal' ? 'selected' : '' }}>Animal</option>
                                <option value="educational" {{ request('category') == 'educational' ? 'selected' : '' }}>Educacional</option>
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">Status</label>
                            <select name="status" class="form-select rounded-2">
                                <option value="">Todos os status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Ativa</option>
                                <option value="finished" {{ request('status') == 'finished' ? 'selected' : '' }}>Finalizada</option>
                            </select>
                        </div>
                        
                        <div class="col-12 mt-3">
                            <div class="d-grid gap-2 d-md-flex">
                                <button class="btn btn-primary rounded-2 fw-semibold flex-fill" type="submit">
                                    <i class="fas fa-filter me-2"></i>Filtrar
                                </button>
                                <a href="{{ route('actions.ong.history') }}" class="btn btn-outline-secondary rounded-2 fw-semibold flex-fill">
                                    <i class="fas fa-undo me-2"></i>Limpar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TABELA -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">Ação</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">Data e Horário</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">Local</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">Status</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0 text-center">Vagas</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0 text-center" style="width: 120px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($actions as $action)
                                    <tr class="border-top">
                                        <td class="px-4 py-3 border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 flex-shrink-0">
                                                    @if($action->image)
                                                        <img src="{{ asset('storage/' . $action->image) }}" 
                                                             alt="{{ $action->name }}" 
                                                             class="rounded-2" 
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary bg-opacity-10 rounded-2 d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 50px;">
                                                            <i class="fas fa-hands-helping text-primary fs-6"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="fw-semibold text-dark d-block">{{ Str::limit($action->name, 40) }}</span>
                                                    <small class="text-muted">
                                                        <i class="fas fa-tag me-1"></i>{{ $action->category }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <div>
                                                <span class="fw-semibold text-dark d-block">
                                                    {{ $action->event_datetime->format('d/m/Y') }}
                                                </span>
                                                <small class="text-muted">
                                                    {{ $action->event_datetime->format('H:i') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <span class="text-muted">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ Str::limit($action->location, 30) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                // USA computed_status para exibição (mais inteligente)
                                                $displayStatus = $action->computed_status;
                                            @endphp

                                            @if ($displayStatus === \App\Enums\ActionStatus::Active)
                                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-2">
                                                    <i class="fas fa-play-circle me-1"></i>Ativa
                                                </span>
                                            @elseif ($displayStatus === \App\Enums\ActionStatus::Finished)
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-2">
                                                    <i class="fas fa-check-circle me-1"></i>Finalizada
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 border-0 text-center">
                                            <span class="fw-semibold text-dark">{{ $action->vacancies }}</span>
                                            <small class="text-muted d-block">vagas</small>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Botão Visualizar -->
                                                <a href="{{ route('actions.show', $action->id) }}" 
                                                   class="btn btn-outline-primary btn-sm rounded-2 fw-semibold px-3"
                                                   title="Ver detalhes da ação">
                                                    <i class="fas fa-eye me-1"></i>Ver
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-5 text-center border-0">
                                            <div class="empty-state">
                                                <i class="fas fa-inbox fs-1 text-muted mb-3"></i>
                                                <h5 class="text-muted mb-2">Nenhuma ação encontrada</h5>
                                                <p class="text-muted small">
                                                    @if(request()->anyFilled(['search', 'category', 'status', 'start_date', 'end_date']))
                                                        Tente ajustar os filtros de busca
                                                    @else
                                                        Você ainda não criou nenhuma ação voluntária
                                                    @endif
                                                </p>
                                                @if(!request()->anyFilled(['search', 'category', 'status', 'start_date', 'end_date']))
                                                    <a href="{{ route('actions.create') }}" class="btn btn-primary mt-2">
                                                        <i class="fas fa-plus me-2"></i>Criar Primeira Ação
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paginação -->
    @if($actions->hasPages())
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Mostrando {{ $actions->firstItem() }} - {{ $actions->lastItem() }} de {{ $actions->total() }} ações
                </div>
                <div>
                    {{ $actions->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection