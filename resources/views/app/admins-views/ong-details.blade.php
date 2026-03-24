@extends('app.layouts.template')

@section('title', 'Detalhes da ONG - ' . $ong->name)

@section('content')
<div class="container-fluid px-4 mt-4 p-5">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1" style="color: var(--text-dark);">Detalhes da ONG</h1>
                    <p class="text-muted mb-0">Informações completas do cadastro da organização</p>
                </div>
                <div>
                    <a href="{{ route('ongs.pending') }}" class="btn btn-outline-primary rounded-2 fw-semibold">
                        <i class="fas fa-arrow-left me-2"></i>Voltar para Lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Principal -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-transparent border-0 pb-0 pt-4 px-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="fw-bold text-dark mb-2">{{ $ong->name }}</h4>
                            <span class="badge rounded-2 px-3 py-2 fw-semibold
                                @if($ong->status === 'approved') bg-success bg-opacity-10 text-success
                                @elseif($ong->status === 'pending') bg-warning bg-opacity-10 text-warning
                                @else bg-danger bg-opacity-10 text-danger @endif">
                                <i class="fas 
                                    @if($ong->status === 'approved') fa-check-circle
                                    @elseif($ong->status === 'pending') fa-clock
                                    @else fa-times-circle @endif me-1"></i>
                                @if($ong->status === 'approved') Aprovada
                                @elseif($ong->status === 'pending') Pendente
                                @else Rejeitada @endif
                            </span>
                        </div>
                        <small class="text-muted">
                            Cadastrada em: {{ $ong->created_at->format('d/m/Y') }}
                        </small>
                    </div>
                </div>

                <div class="card-body pt-3 px-4">
                    <div class="row">
                        <!-- Informações Básicas -->
                        <div class="col-lg-6 mb-4">
                            <h5 class="fw-semibold text-dark mb-3 border-bottom pb-2">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Informações Básicas
                            </h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted mb-1">CNPJ</label>
                                <p class="mb-0 text-dark">{{ $ong->cnpj }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted mb-1">E-mail</label>
                                <p class="mb-0 text-dark">{{ $ong->email }}</p>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted mb-1">Telefone</label>
                                <p class="mb-0 text-dark">{{ $ong->phone ?? 'Não informado' }}</p>
                            </div>
                        </div>

                        <!-- Endereço e Descrição -->
                        <div class="col-lg-6 mb-4">
                            <h5 class="fw-semibold text-dark mb-3 border-bottom pb-2">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>Localização
                            </h5>

                            <div class="mb-4">
                                <label class="form-label fw-semibold small text-muted mb-1">Endereço</label>
                                <p class="mb-0 text-dark">{{ $ong->address ?? 'Não informado' }}</p>
                            </div>

                            <h5 class="fw-semibold text-dark mb-3 border-bottom pb-2 mt-4">
                                <i class="fas fa-file-alt me-2 text-primary"></i>Descrição
                            </h5>

                            <div class="mb-3">
                                <label class="form-label fw-semibold small text-muted mb-1">Sobre a Organização</label>
                                <div class="bg-light rounded-2 p-3">
                                    <p class="mb-0 text-dark">{{ $ong->description ?? 'Nenhuma descrição fornecida.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <!-- Estatísticas -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5 class="fw-semibold text-dark mb-3 border-bottom pb-2">
                                <i class="fas fa-chart-bar me-2 text-primary"></i>Estatísticas
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="card bg-primary bg-opacity-10 border-0">
                                        <div class="card-body text-center py-3">
                                            <i class="fas fa-hands-helping fs-4 text-primary mb-2"></i>
                                            <h5 class="fw-bold text-dark mb-1">{{ $ong->user->voluntaryActions->count() }}</h5>
                                            <small class="text-muted">Ações Criadas</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="card bg-success bg-opacity-10 border-0">
                                        <div class="card-body text-center py-3">
                                            <i class="fas fa-users fs-4 text-success mb-2"></i>
                                            <h5 class="fw-bold text-dark mb-1">
                                                {{ $ong->user->voluntaryActions->sum(function($action) {
                                                    return $action->registrations->where('status', 'active')->count();
                                                }) }}
                                            </h5>
                                            <small class="text-muted">Voluntários Inscritos</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="card bg-info bg-opacity-10 border-0">
                                        <div class="card-body text-center py-3">
                                            <i class="fas fa-calendar-check fs-4 text-info mb-2"></i>
                                            <h5 class="fw-bold text-dark mb-1">
                                                {{ $ong->user->voluntaryActions->where('event_datetime', '>=', now())->count() }}
                                            </h5>
                                            <small class="text-muted">Ações Futuras</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="card bg-warning bg-opacity-10 border-0">
                                        <div class="card-body text-center py-3">
                                            <i class="fas fa-history fs-4 text-warning mb-2"></i>
                                            <h5 class="fw-bold text-dark mb-1">
                                                {{ $ong->user->voluntaryActions->where('event_datetime', '<', now())->count() }}
                                            </h5>
                                            <small class="text-muted">Ações Realizadas</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    <!-- Ações de Administrador -->
                    @if($ong->status === 'pending')
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="border-top pt-4">
                                <h5 class="fw-semibold text-dark mb-3">
                                    <i class="fas fa-cog me-2 text-primary"></i>Ações Administrativas
                                </h5>
                                
                                <div class="d-flex gap-3">
                                    <form action="{{ route('ongs.approve', $ong) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-success rounded-2 fw-semibold px-4"
                                                onclick="return confirm('Tem certeza que deseja APROVAR esta ONG?')">
                                            <i class="fas fa-check me-2"></i>Aprovar ONG
                                        </button>
                                    </form>

                                    <form action="{{ route('ongs.reject', $ong) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-danger rounded-2 fw-semibold px-4"
                                                onclick="return confirm('Tem certeza que deseja REJEITAR esta ONG?')">
                                            <i class="fas fa-times me-2"></i>Rejeitar ONG
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection