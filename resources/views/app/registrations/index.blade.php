@extends('app.layouts.template')

@section('title', 'Minhas Inscrições')

@section('content')
<div class="container-fluid px-4 mt-4 p-5">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1" style="color: var(--text-dark);">Minhas Inscrições</h1>
                    <p class="text-muted mb-0">Gerencie suas inscrições em ações voluntárias</p>
                </div>
                <a href="{{ route('actions.index') }}" class="btn btn-primary rounded-2 fw-semibold">
                    <i class="fas fa-plus-circle me-2"></i> Nova Inscrição
                </a>
            </div>
        </div>
    </div>

    <!-- Mensagens de Sucesso/Erro -->
    @if(session('success'))
        @if(is_array(session('success')) && isset(session('success')['type']))
            <!-- Mensagem personalizada (como na view de detalhes da ação) -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-check-circle me-3 mt-1 fs-5"></i>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-2">{{ session('success')['title'] ?? 'Sucesso!' }}</h6>
                                <p class="mb-0">{{ session('success')['message'] ?? 'Operação realizada com sucesso!' }}</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Mensagem de sucesso simples -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        @if(is_array(session('success')))
                            {{ session('success')['message'] ?? session('success')['title'] ?? 'Operação realizada com sucesso!' }}
                        @else
                            {{ session('success') }}
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif
    @endif

    @if(session('error'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    @if(is_array(session('error')))
                        {{ session('error')['message'] ?? session('error')['title'] ?? 'Ocorreu um erro!' }}
                    @else
                        {{ session('error') }}
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-4 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">Filtrar por Status</label>
                            <select id="statusFilter" class="form-select rounded-2">
                                <option value="active">Inscrições Ativas</option>
                                <option value="all">Todas as Inscrições</option>
                                <option value="attended">Participadas</option>
                                <option value="not_participated">Não Participou</option>
                                <option value="cancelled">Canceladas</option>
                            </select>
                        </div>
                        <div class="col-lg-8 col-md-6">
                            <div class="d-flex align-items-center h-100">
                                <div class="text-muted small">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <span id="resultsCount">Carregando...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Inscrições -->
<!-- Lista de Inscrições -->
@if($registrations->count() > 0)
    <div class="row registrations-page" id="registrationsList">
@foreach($registrations as $registration)
<div class="col-xl-6 col-lg-12 mb-4 registration-item" 
     data-status="{{ $registration->status }}"
     data-participated="{{ $registration->participated === null ? 'null' : ($registration->participated ? 'true' : 'false') }}">
    
    <div class="card border-0 shadow-sm rounded-3 h-100">
        <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <!-- Badge Status da Inscrição -->
                    <span class="badge rounded-2 px-3 py-2 fw-semibold
                        @if($registration->status == 'active') bg-success bg-opacity-10 text-success
                        @elseif($registration->status == 'cancelled') bg-danger bg-opacity-10 text-danger
                        @else bg-warning bg-opacity-10 text-warning @endif">
                        <i class="fas 
                            @if($registration->status == 'active') fa-check-circle
                            @elseif($registration->status == 'cancelled') fa-times-circle
                            @else fa-clock @endif me-1"></i>
                        @if($registration->status == 'active') Inscrição Ativa
                        @elseif($registration->status == 'cancelled') Cancelada
                        @else {{ $registration->status }} @endif
                    </span>

                    <!-- Badge Participação -->
                    @if($registration->participated === true)
                        <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-2 ms-2">
                            <i class="fas fa-check-circle me-1"></i>Participou
                        </span>
                    @elseif($registration->participated === false)
                        <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-2 ms-2">
                            <i class="fas fa-times-circle me-1"></i>Não Participou
                        </span>
                    @elseif($registration->voluntaryAction->event_datetime && $registration->voluntaryAction->event_datetime->isPast())
                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-2 ms-2">
                            <i class="fas fa-clock me-1"></i>Pendente
                        </span>
                    @endif
                </div>
                <small class="text-muted">
                    {{ $registration->registered_at->format('d/m/Y') }}
                </small>
            </div>
        </div>

        <div class="card-body pt-3 px-4">
            <h5 class="fw-bold text-dark mb-3">
                {{ $registration->voluntaryAction->name }}
            </h5>

            <!-- Informações da Ação -->
            <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                    <div class="icon-container bg-primary bg-opacity-10 rounded-2 me-3">
                        <i class="fas fa-calendar-alt text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">
                            @if($registration->voluntaryAction->event_datetime)
                                {{ $registration->voluntaryAction->event_datetime->format('d/m/Y \à\s H:i') }}
                                @if($registration->voluntaryAction->event_datetime->isPast())
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary ms-1">Realizada</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success ms-1">Futura</span>
                                @endif
                            @else
                                Data não definida
                            @endif
                        </small>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <div class="icon-container bg-primary bg-opacity-10 rounded-2 me-3">
                        <i class="fas fa-map-marker-alt text-primary"></i>
                    </div>
                    <div>
                        <small class="text-muted">{{ $registration->voluntaryAction->location }}</small>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <div class="icon-container bg-primary bg-opacity-10 rounded-2 me-3">
                        <i class="fas fa-tag text-primary"></i>
                    </div>
                    <div>
                        <span class="badge bg-light text-dark rounded-2">
                            {{ $registration->voluntaryAction->category }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Alertas de Participação -->
            @if($registration->participated === true)
                <div class="alert alert-success alert-dismissible fade show py-2 mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle me-2"></i>
                        <div>
                            <strong class="d-block">Participação Confirmada</strong>
                            <small class="d-block">Sua presença foi registrada pela organização</small>
                        </div>
                    </div>
                </div>
            @elseif($registration->participated === false)
                <div class="alert alert-warning alert-dismissible fade show py-2 mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-times-circle me-2"></i>
                        <div>
                            <strong class="d-block">Não Participou</strong>
                            <small class="d-block">Sua não participação foi registrada pela organização</small>
                        </div>
                    </div>
                </div>
            @elseif($registration->voluntaryAction->event_datetime && $registration->voluntaryAction->event_datetime->isPast())
                <div class="alert alert-info alert-dismissible fade show py-2 mb-3" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-clock me-2"></i>
                        <div>
                            <strong class="d-block">Ação Realizada</strong>
                            <small class="d-block">Aguardando confirmação de participação</small>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Botões -->
            <div class="d-flex flex-wrap gap-2 pt-2">
                <a href="{{ route('actions.show', $registration->voluntaryAction) }}" 
                class="btn btn-outline-primary btn-sm rounded-2 fw-semibold px-3">
                    <i class="fas fa-eye me-1"></i> Ver Ação
                </a>

               <!-- Botão Cancelar (apenas para inscrições ativas E ações futuras) -->
                @if($registration->status == 'active' && $registration->voluntaryAction->event_datetime && $registration->voluntaryAction->event_datetime->isFuture())
                    <form action="{{ route('registrations.destroy', $registration) }}" 
                        method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-outline-danger btn-sm rounded-2 fw-semibold px-3"
                                onclick="return confirm('Tem certeza que deseja cancelar esta inscrição?')">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </button>
                    </form>
                @elseif($registration->status == 'active' && $registration->voluntaryAction->event_datetime && $registration->voluntaryAction->event_datetime->isPast())
                    <button class="btn btn-outline-secondary btn-sm rounded-2 fw-semibold px-3" disabled
                            title="Não é possível cancelar após a ação ter sido realizada">
                        <i class="fas fa-times me-1"></i> Cancelar
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
    </div>
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-center mt-4" id="paginationContainer" style="display: none !important;">
            {{ $registrations->links() }}
        </div>

    @else
        <!-- Estado Vazio -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body py-5">
                        <div class="text-center">
                            <div class="empty-state-icon mb-4">
                                <i class="fas fa-calendar-times fs-1 text-muted opacity-50"></i>
                            </div>
                            <h5 class="text-muted mb-3">Nenhuma inscrição encontrada</h5>
                            <p class="text-muted mb-4">Você ainda não se inscreveu em nenhuma ação voluntária.</p>
                            <a href="{{ route('actions.index') }}" class="btn btn-primary rounded-2 fw-semibold px-4">
                                <i class="fas fa-search me-2"></i> Explorar Ações
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusFilter = document.getElementById('statusFilter');
    const registrationItems = document.querySelectorAll('.registration-item');
    const resultsCount = document.getElementById('resultsCount');
    const paginationContainer = document.getElementById('paginationContainer');

    // Contador inicial
    updateResultsCount('active');

    console.log('Filtro carregado - Itens encontrados:', registrationItems.length);

    if (statusFilter && registrationItems.length > 0) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            console.log('Filtro alterado para:', selectedStatus);
            
            filterRegistrations(selectedStatus);
            updateResultsCount(selectedStatus);
            togglePagination(selectedStatus);
        });
    }
});

function filterRegistrations(selectedStatus) {
    const registrationItems = document.querySelectorAll('.registration-item');
    let visibleItems = 0;
    
    registrationItems.forEach(item => {
        const participated = item.getAttribute('data-participated');
        
        let shouldShow = false;
        
        if (selectedStatus === 'all') {
            shouldShow = true;
        } else if (selectedStatus === 'attended') {
            shouldShow = participated === 'true';
        } else if (selectedStatus === 'not_participated') {
            shouldShow = participated === 'false';
        } else if (selectedStatus === 'active') {
            shouldShow = item.getAttribute('data-status') === 'active';
        } else if (selectedStatus === 'cancelled') {
            shouldShow = item.getAttribute('data-status') === 'cancelled';
        }
        
        if (shouldShow) {
            item.style.display = 'block';
            visibleItems++;
        } else {
            item.style.display = 'none';
        }
    });

    // ⬇️ ADICIONAR ESTAS LINHAS
if (visibleItems === 0) {
    showNoResultsMessage(selectedStatus);
} else {
    hideNoResultsMessage();
}
    
}

function updateResultsCount(selectedStatus) {
    const resultsCount = document.getElementById('resultsCount');
    const registrationItems = document.querySelectorAll('.registration-item');
    
    let visibleItems = 0;
    let totalItems = registrationItems.length;
    
    if (selectedStatus === 'all') {
        visibleItems = totalItems;
    } else {
        registrationItems.forEach(item => {
            const itemStatus = item.getAttribute('data-status');
            const participated = item.getAttribute('data-participated');
            
            if (selectedStatus === 'not_participated') {
                if (participated === 'false' && itemStatus === 'active') {
                    visibleItems++;
                }
            } else if (selectedStatus === 'attended') {
                if (participated === 'true' && itemStatus === 'active') {
                    visibleItems++;
                }
            } else if (itemStatus === selectedStatus) {
                visibleItems++;
            }
        });
    }
    
    if (resultsCount) {
        if (selectedStatus === 'all') {
            resultsCount.innerHTML = `Mostrando todas as ${visibleItems} inscrição(ões)`;
        } else {
            const statusText = getStatusText(selectedStatus);
            resultsCount.innerHTML = `${visibleItems} inscrição(ões) ${statusText}(s)`;
        }
    }
}

function togglePagination(selectedStatus) {
    const paginationContainer = document.getElementById('paginationContainer');
    if (paginationContainer) {
        if (selectedStatus === 'all') {
            paginationContainer.style.display = 'flex';
        } else {
            paginationContainer.style.display = 'none';
        }
    }
}

function showNoResultsMessage(status) {
    // Remove mensagem anterior se existir
    hideNoResultsMessage();
    
    const statusText = getStatusText(status);
    const messageDiv = document.createElement('div');
    messageDiv.id = 'noResultsMessage';
    messageDiv.className = 'col-12';
    
    // Só mostra o botão "Mostrar Todas" se NÃO estiver no filtro "all"
    const showButton = status !== 'all';
    
    messageDiv.innerHTML = `
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body py-5">
                <div class="text-center">
                    <div class="empty-state-icon mb-4">
                        <i class="fas fa-search fs-1 text-muted opacity-50"></i>
                    </div>
                    <h5 class="text-muted mb-3">Nenhuma inscrição ${statusText}</h5>
                    <p class="text-muted mb-4">Não foram encontradas inscrições com o status selecionado.</p>
                    ${showButton ? `
                    <button onclick="resetFilter()" class="btn btn-outline-primary rounded-2 fw-semibold px-4">
                        <i class="fas fa-list-check me-2"></i> Mostrar Todas as Inscrições
                    </button>
                    ` : ''}
                </div>
            </div>
        </div>
    `;
    
    const registrationsList = document.getElementById('registrationsList');
    if (registrationsList) {
        registrationsList.appendChild(messageDiv);
    }
}

function resetFilter() {
    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.value = 'all';
        statusFilter.dispatchEvent(new Event('change'));
    }
}

function hideNoResultsMessage() {
    const existingMessage = document.getElementById('noResultsMessage');
    if (existingMessage) {
        existingMessage.remove();
    }
}

function getStatusText(status) {
    const statusMap = {
        'active': 'ativa',
        'cancelled': 'cancelada', 
        'attended': 'participada',
        'not_participated': 'não participada',
        'all': 'todas'
    };
    return statusMap[status] || '';
}
</script>
@endsection