@extends('app.layouts.template')

@section('title', 'Dashboard')

@section('content')

<div class="container-fluid px-4 mt-4">

    {{-- Hero Section com Carousel --}}
    <div class="row mb-5">
        <div class="col-12">
            <div id="heroCarousel" class="carousel slide rounded-3 shadow-lg" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                </div>
                <div class="carousel-inner rounded-3">
                    <div class="carousel-item active">
                        <img src="{{ asset('images/meio_ambiente_certo.png') }}" class="d-block w-100 carousel-image" alt="Voluntários fazendo a diferença">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="display-5 fw-bold text-white">Faça a Diferença</h2>
                            <p class="lead text-white">Junte-se a milhares de voluntários transformando vidas</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/assistencia_social.png') }}" class="d-block w-100 carousel-image" alt="Comunidade ativa">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="display-5 fw-bold text-white">Comunidade Ativa</h2>
                            <p class="lead text-white">Participe de ações que realmente importam</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/causa_animal.png') }}" class="d-block w-100 carousel-image" alt="Transforme vidas">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="display-5 fw-bold text-white">Transforme Vidas</h2>
                            <p class="lead text-white">Seu tempo pode mudar o mundo</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('images/educacao.png') }}" class="d-block w-100 carousel-image" alt="Educação e conhecimento">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="display-5 fw-bold text-white">Eduque para o Futuro</h2>
                            <p class="lead text-white">Compartilhe conhecimento e transforme realidades</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Cards de Categorias --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="row g-4">
                {{-- Card Ambiental --}}
                <div class="col-md-3 col-sm-6">
                    <div class="category-card bg-white rounded-3 p-4 shadow-sm border-start border-4 border-success">
                        <div class="d-flex align-items-center">
                            <div class="category-icon me-3" style="background-color: var(--accent); padding: 12px; border-radius: 12px;">
                                <i class="fas fa-leaf text-success fs-4"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold mb-1 text-dark">Ambiental</h3>
                                <p class="text-muted mb-0 small">Preservação e natureza</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="fas fa-seedling me-1"></i>
                                Ações ativas
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Social --}}
                <div class="col-md-3 col-sm-6">
                    <div class="category-card bg-white rounded-3 p-4 shadow-sm border-start border-4 border-primary">
                        <div class="d-flex align-items-center">
                            <div class="category-icon me-3" style="background-color: var(--primary-light); padding: 12px; border-radius: 12px;">
                                <i class="fas fa-hands-helping text-primary fs-4"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold mb-1 text-dark">Social</h3>
                                <p class="text-muted mb-0 small">Comunidade e pessoas</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-users me-1"></i>
                                Ações ativas
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Animal --}}
                <div class="col-md-3 col-sm-6">
                    <div class="category-card bg-white rounded-3 p-4 shadow-sm border-start border-4 border-warning">
                        <div class="d-flex align-items-center">
                            <div class="category-icon me-3" style="background-color: #FEF3C7; padding: 12px; border-radius: 12px;">
                                <i class="fas fa-paw text-warning fs-4"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold mb-1 text-dark">Animal</h3>
                                <p class="text-muted mb-0 small">Proteção aos animais</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-warning bg-opacity-10 text-warning">
                                <i class="fas fa-heart me-1"></i>
                                Ações ativas
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Card Educacional --}}
                <div class="col-md-3 col-sm-6">
                    <div class="category-card bg-white rounded-3 p-4 shadow-sm border-start border-4 border-info">
                        <div class="d-flex align-items-center">
                            <div class="category-icon me-3" style="background-color: #E0F2FE; padding: 12px; border-radius: 12px;">
                                <i class="fas fa-graduation-cap text-info fs-4"></i>
                            </div>
                            <div>
                                <h3 class="h5 fw-bold mb-1 text-dark">Educacional</h3>
                                <p class="text-muted mb-0 small">Educação e conhecimento</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge bg-info bg-opacity-10 text-info">
                                <i class="fas fa-book me-1"></i>
                                Ações ativas
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Header das Ações --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="h3 fw-bold mb-1" style="color: var(--text-dark);">Últimas Postagens</h2>
                    <p class="text-muted mb-0 pb-3">Participe e faça parte da transformação!</p>
                </div>
            </div>
        </div>
    </div>

   {{-- Lista de ações --}}
@if ($actions->isEmpty())
    <div class="text-center py-5 my-5 P-5">
        <div class="empty-state bg-white rounded-3 p-5 shadow-sm">
            <i class="fas fa-inbox fs-1 text-muted mb-3"></i>
            <h5 class="text-muted">Ainda não existem ações voluntárias cadastradas.</h5>
        </div>
    </div>
@else
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
        @foreach ($actions as $action)
        <div class="col">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                <!-- Imagem -->
                <div class="position-relative overflow-hidden">
                    @if($action->image)
                        <img src="{{ asset('storage/' . $action->image) }}" 
                             class="card-img-top w-100" 
                             alt="{{ $action->name }}"
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center w-100" 
                             style="height: 200px;">
                            <i class="bi bi-heart text-muted" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                    
                    <!-- Badge de tempo -->
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge bg-dark bg-opacity-75 px-2 py-1 small">
                            <i class="bi bi-clock me-1"></i>{{ $action->created_at->diffForHumans(['parts' => 1, 'short' => true]) }}
                        </span>
                    </div>

                    <!-- Tipo da Ação -->
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-primary px-2 py-1 small text-capitalize">
                            {{ $action->category }}
                        </span>
                    </div>
                </div>

                <div class="card-body d-flex flex-column p-3">
                    <!-- ONG e Localização - mesma linha -->
                    <div class="d-flex justify-content-between align-items-center mb-2 flex-nowrap">
                        <!-- ONG -->
                        @if($action->user && $action->user->ong)
                            <span class="badge bg-light text-dark border small text-truncate me-2" style="max-width: 120px;">
                                <i class="bi bi-building me-1 text-primary"></i>
                                {{ Str::limit($action->user->ong->name, 15) }}
                            </span>
                        @else
                            <span class="badge bg-light text-dark border small text-truncate me-2" style="max-width: 120px;">
                                <i class="bi bi-building me-1 text-muted"></i>
                                Organização
                            </span>
                        @endif

                        <!-- Localização -->
                        <div class="d-flex align-items-center text-muted small text-truncate" style="max-width: 120px;">
                            <i class="bi bi-geo-alt me-1 flex-shrink-0"></i>
                            <span class="text-truncate">{{ Str::limit($action->location, 12) }}</span>
                        </div>
                    </div>

                    <!-- Título -->
                    <h6 class="card-title fw-bold text-dark mb-2 line-clamp-2" style="min-height: 3em;">
                        {{ $action->name }}
                    </h6>

                    <!-- Descrição -->
                    <p class="card-text text-muted small flex-grow-1 mb-3 line-clamp-3">
                        {{ Str::limit($action->description, 120) }}
                    </p>

                    <!-- Data e Botão -->
                    <div class="mt-auto pt-2">
                        <!-- Data -->
                        <div class="d-flex align-items-center text-muted small mb-2">
                            <i class="bi bi-calendar3 me-2 flex-shrink-0"></i>
                            <span class="text-truncate">
                                @if($action->event_datetime)
                                    {{ $action->event_datetime->format('d/m/Y') }}
                                @else
                                    Data a definir
                                @endif
                            </span>
                        </div>

                        <!-- Botão -->
                        <a href="{{ route('actions.show', $action) }}" 
                           class="btn btn-outline-primary btn-sm w-100 py-2">
                            <i class="bi bi-eye me-2"></i>Ver detalhes
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

</div>
@endsection