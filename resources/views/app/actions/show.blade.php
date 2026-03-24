@extends('app.layouts.template')

@section('title', $action->name ?? 'Detalhes da Ação')

@section('content')

<div class="container-fluid action-details-container py-4 p-5">
    @if(session('success'))
        @if(is_array(session('success')) && isset(session('success')['type']) && session('success')['type'] === 'registration_success')
            <!-- Mensagem personalizada para inscrição -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show" role="alert" style="border-left: 4px solid #198754;">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle fs-4 text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fw-bold text-success mb-1">{{ session('success')['title'] }}</h6>
                                <p class="mb-0 text-dark">{{ session('success')['message'] }}</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Mensagem de sucesso genérica -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ is_array(session('success')) ? session('success')['message'] ?? session('success')['title'] : session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <div class="row justify-content-center">
        <div class="col-xxl-10 col-12">
            <!-- Card Principal -->
            <div class="card action-details-card shadow-lg">

                 <!-- Header Simples sem Imagem -->
                <div class="action-header-simple position-relative py-4 px-4">
                    <!-- Botão Voltar -->
                    <div class="action-back-btn">
                        <a href="{{ route('actions.index') }}" class="btn btn-back">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>

                <!-- Conteúdo Principal -->
                <div class="action-content">
                    <div class="row g-4">
                        <!-- Coluna de Informações -->
                        <div class="col-lg-8">
                            <!-- Título e Badges -->
                            <div class="action-title-section mb-4">
                                <h1 class="action-title">{{ $action->name }}</h1>
                                <div class="action-badges">
                                    <span class="badge category-badge">{{ $action->category }}</span>
                                    <span class="badge status-badge 
                                        @if($action->computed_status === \App\Enums\ActionStatus::Active) bg-success 
                                        @elseif($action->computed_status === \App\Enums\ActionStatus::Cancelled) bg-danger 
                                        @else bg-primary @endif">
                                        {{ $action->computed_status === \App\Enums\ActionStatus::Active ? 'Ativa' : 
                                        ($action->computed_status === \App\Enums\ActionStatus::Cancelled ? 'Cancelada' : 'Finalizada') }}
                                    </span>
                                </div>
                            </div>

                            <!-- Informações da ONG -->
                            @if($action->user && $action->user->ong)
                            <div class="info-card mb-4">
                                <div class="info-header">
                                    <i class="fas fa-building"></i>
                                    <h5>Organização Responsável</h5>
                                </div>
                                <p class="info-content">{{ $action->user->ong->name ?? 'ONG' }}</p>
                            </div>
                            @endif

                            <!-- Descrição -->
                            <div class="info-card mb-4">
                                <div class="info-header">
                                    <i class="fas fa-file-alt"></i>
                                    <h5>Sobre esta Ação</h5>
                                </div>
                                <div class="description-content">
                                    <p>{{ $action->description ?: 'Nenhuma descrição fornecida.' }}</p>
                                </div>
                            </div>

                            <!-- Lista de Inscritos (apenas para criador/admin) -->
                            @can('update', $action)
                            <div class="info-card">
                                <div class="info-header">
                                    <i class="fas fa-list-check"></i>
                                    <h5>Voluntários Inscritos ({{ $occupiedVacancies }})</h5>
                                </div>
                                
                                @if($action->registrations->where('status', 'active')->count() > 0)
                                @php
                                    $eventoLiberado = now()->gte($action->event_datetime);
                                @endphp

                                @if(!$eventoLiberado)
                                    <div class="alert alert-info mb-3 py-2 px-3">
                                        <i class="fas fa-info-circle"></i>
                                        A verificação de participação só estará disponível após a data da ação.
                                    </div>
                                @endif

                                    <div class="volunteers-list">
                                        @foreach($action->registrations->where('status', 'active') as $registration)
                                            <div class="volunteer-item">
                                                <div class="volunteer-info">
                                                    <div class="volunteer-avatar">
                                                        <i class="fas fa-user-circle"></i>
                                                    </div>
                                                    <div class="volunteer-details">
                                                        <strong>{{ $registration->user->name }}</strong>
                                                        <small>{{ $registration->user->email }}</small>
                                                        <div class="registration-date">
                                                            Inscrito em: {{ $registration->registered_at->format('d/m/Y H:i') }}
                                                        </div>
                                                        <!-- Status de Participação -->
                                                        @if($registration->participated !== null)
                                                            <div class="participation-status mt-1">
                                                                <span class="badge {{ $registration->participated ? 'bg-success' : 'bg-warning' }}">
                                                                    {{ $registration->participated ? 'Participou' : 'Não Participou' }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                
                                                <!-- Ações de Participação -->
                                                @if($eventoLiberado)
                                                <div class="volunteer-actions">
                                                    <form action="{{ route('registrations.markParticipation', $registration->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="participated" value="1">
                                                        <button 
                                                            type="submit" 
                                                            class="btn btn-success btn-sm"
                                                            title="Marcar como participou"
                                                            onclick="return confirm('Confirmar que {{ $registration->user->name }} participou da ação?')"
                                                        >
                                                            <i class="fas fa-check"></i> Participou
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('registrations.markParticipation', $registration->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="participated" value="0">
                                                        <button 
                                                            type="submit" 
                                                            class="btn btn-warning btn-sm"
                                                            title="Marcar como não participou"
                                                            onclick="return confirm('Confirmar que {{ $registration->user->name }} NÃO participou da ação?')"
                                                        >
                                                            <i class="fas fa-times"></i> Não Participou
                                                        </button>
                                                    </form>
                                                </div>
                                                @else
                                                <div class="volunteer-actions">
                                                    <button class="btn btn-success btn-sm" disabled>
                                                        <i class="fas fa-check"></i> Participou
                                                    </button>
                                                    <button class="btn btn-warning btn-sm" disabled>
                                                        <i class="fas fa-times"></i> Não Participou
                                                    </button>
                                                </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state">
                                        <i class="fas fa-users"></i>
                                        <p>Nenhum voluntário inscrito ainda.</p>
                                    </div>
                                @endif
                            </div>
                            @endcan
                        </div>

                        <!-- Sidebar de Detalhes -->
                        <div class="col-lg-4">
                            <div class="details-sidebar">
                                <!-- Card de Inscrição -->
                                <div class="sidebar-card">
                                    <div class="sidebar-card-header">
                                        <i class="fas fa-user-plus"></i>
                                        <h6>Participar desta Ação</h6>
                                    </div>
                                    <div class="sidebar-card-body">
                                        <!-- Vagas -->
                                        <div class="vacancies-info mb-3">
                                            <div class="vacancies-progress">
                                                <div class="progress">
                                                    <div class="progress-bar 
                                                        @if($availableVacancies > 0) bg-success 
                                                        @else bg-danger @endif" 
                                                        style="width: {{ ($occupiedVacancies / $action->vacancies) * 100 }}%">
                                                    </div>
                                                </div>
                                                <div class="vacancies-text">
                                                    <strong>{{ $availableVacancies }}</strong> de 
                                                    <strong>{{ $action->vacancies }}</strong> vagas disponíveis
                                                    @if($occupiedVacancies > 0)
                                                        <small>({{ $occupiedVacancies }} já inscrito(s))</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Botão de Inscrição -->
                                        <div class="registration-actions">
                                            @auth
                                                <!-- VERIFICA SE O USUÁRIO NÃO É UMA ONG -->
                                                @if(!auth()->user()->hasRole(\App\Enums\Role::Ong))
                                                    @if($isRegistered)
                                                        <button class="btn btn-registered" disabled>
                                                            <i class="fas fa-check-circle"></i> Já Inscrito
                                                        </button>
                                                        
                                                        @php
                                                            $userRegistration = \App\Models\Registration::where('user_id', auth()->id())
                                                                ->where('voluntary_action_id', $action->id)
                                                                ->where('status', 'active')
                                                                ->first();
                                                        @endphp
                                                    @if($userRegistration && $userRegistration->status == 'active')
                                                        @if($action->event_datetime && $action->event_datetime->isFuture())
                                                            <form action="{{ route('registrations.destroy', $userRegistration) }}" 
                                                                method="POST" class="w-100 mt-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-cancel-registration" 
                                                                        onclick="return confirm('Tem certeza que deseja cancelar sua inscrição?')">
                                                                    <i class="fas fa-times-circle"></i> Cancelar Inscrição
                                                                </button>
                                                            </form>
                                                        @else
                                                            <div class="alert alert-info py-2 mt-2 mb-0">
                                                                <i class="fas fa-info-circle me-2"></i>
                                                                <small>Não é possível cancelar inscrição após a ação ter sido realizada</small>
                                                            </div>
                                                        @endif
                                                    @endif
                                                    @elseif($availableVacancies > 0 && $action->computed_status === \App\Enums\ActionStatus::Active)
                                                        <!-- ADICIONEI UMA VERIFICAÇÃO EXTRA DE DATA AQUI -->
                                                        @if($action->event_datetime && $action->event_datetime > now())
                                                            <form action="{{ route('registrations.store') }}" method="POST" class="w-100">
                                                                @csrf
                                                                <input type="hidden" name="voluntary_action_id" value="{{ $action->id }}">
                                                                <button type="submit" class="btn btn-primary btn-register">
                                                                    <i class="fas fa-user-plus"></i> Inscrever-se
                                                                </button>
                                                            </form>
                                                        @else
                                                            <button class="btn btn-disabled" disabled>
                                                                <i class="fas fa-user-slash"></i> 
                                                                Ação Já Ocorreu
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button class="btn btn-disabled" disabled>
                                                            <i class="fas fa-user-slash"></i> 
                                                            @if($action->computed_status !== \App\Enums\ActionStatus::Active)
                                                                Ação Inativa
                                                            @else
                                                                Vagas Esgotadas
                                                            @endif
                                                        </button>
                                                    @endif
                                                @else
                                                    <!-- MENSAGEM PARA ONGs -->
                                                    <div class="alert alert-info mb-0">
                                                        <i class="fas fa-building"></i>
                                                        <strong>Organizações</strong><br>
                                                        ONGs não podem se inscrever em ações voluntárias. 
                                                        Esta funcionalidade é exclusiva para voluntários.
                                                    </div>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-primary btn-login">
                                                    <i class="fas fa-sign-in-alt"></i> Faça Login para se Inscrever
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações da Ação -->
                                <div class="sidebar-card">
                                    <div class="sidebar-card-header">
                                        <i class="fas fa-info-circle"></i>
                                        <h6>Informações</h6>
                                    </div>
                                    <div class="sidebar-card-body">
                                        <!-- Localização -->
                                        <div class="info-item">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <div class="info-text">
                                                <strong>Localização</strong>
                                                <span>{{ $action->location }}</span>
                                            </div>
                                        </div>

                                        <!-- Data e Horário -->
                                        <div class="info-item">
                                            <i class="fas fa-calendar-alt"></i>
                                            <div class="info-text">
                                                <strong>Data e Horário</strong>
                                                <span class="@if(!$action->event_datetime) text-warning @endif">
                                                    {{ $action->event_datetime ? $action->event_datetime->format('d/m/Y \à\s H:i') : 'Data não definida' }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Categoria -->
                                        <div class="info-item">
                                            <i class="fas fa-tag"></i>
                                            <div class="info-text">
                                                <strong>Categoria</strong>
                                                <span class="text-capitalize">{{ $action->category }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Ações do Criador/Admin -->
                                @canany(['update', 'delete'], $action)
                                <div class="sidebar-card">
                                    <div class="sidebar-card-header">
                                        <i class="fas fa-cog"></i>
                                        <h6>Gerenciar Ação</h6>
                                    </div>
                                    <div class="sidebar-card-body">
                                        <div class="management-actions">
                                            @can('update', $action)
                                                @if($action->event_datetime && $action->event_datetime->isFuture())
                                                    <a href="{{ route('actions.edit', $action) }}" class="btn btn-warning btn-sm btn-management">
                                                        <i class="fas fa-edit"></i> Editar Ação
                                                    </a>
                                                @else
                                                    <button class="btn btn-outline-secondary btn-sm btn-management" disabled
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-placement="top"
                                                            title="Não é possível editar a ação após ela ter sido realizada">
                                                        <i class="fas fa-edit"></i> Editar Ação
                                                    </button>
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="fas fa-info-circle"></i> Ação já realizada
                                                    </small>
                                                @endif
                                            @endcan

                                            @can('delete', $action)
                                               @if($registers == 0)
                                                    <form action="{{ route('actions.destroy', $action->id) }}" method="POST" 
                                                        onsubmit="return confirm('Tem certeza que deseja excluir esta ação?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm btn-management">
                                                            <i class="fa-solid fa-trash"></i> Excluir ação</button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-danger btn-sm btn-management" disabled>
                                                        <i class="fa-solid fa-trash"></i> Excluir ação
                                                    </button>
                                                    <p class="text-danger mt-1">
                                                        Não é possível excluir esta ação. Existem voluntários inscritos.
                                                    </p>
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                                @endcanany
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection