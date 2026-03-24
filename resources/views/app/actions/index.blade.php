@extends('app.layouts.template')


@section('title', 'Ações Voluntárias')

@section('content')
<div class="container-fluid actions-page py-4 p-5">
    <div class="row justify-content-center">
        <div class="col-xxl-11 col-12">
            <!-- Header da Página -->
            <div class="page-header mb-5 text-center">
                <div class="header-icon mb-3">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h1 class="page-title">Ações Voluntárias</h1>
                <p class="page-subtitle">Encontre oportunidades para fazer a diferença na sua comunidade</p>
            </div>

              @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Filtros Simplificados -->
            <div class="filters-section mb-5">
                <div class="card filter-card">
                    <div class="card-body">
                        <form action="{{ route('actions.index') }}" method="GET" id="filter-form">
                            <div class="row g-3 align-items-end">
                                <!-- Pesquisa por Nome -->
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold">Nome da Ação</label>
                                    <div class="search-box">
                                        <i class="fas fa-search"></i>
                                        <input type="text" 
                                               name="search" 
                                               class="form-control search-input" 
                                               placeholder="Digite o nome da ação..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>

                                <!-- Categoria -->
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold">Categoria</label>
                                    <select class="form-select filter-select" name="category">
                                        <option value="">Todas as categorias</option>
                                        <option value="environmental" {{ request('category') == 'environmental' ? 'selected' : '' }}>Ambiental</option>
                                        <option value="social" {{ request('category') == 'social' ? 'selected' : '' }}>Social</option>
                                        <option value="animal" {{ request('category') == 'animal' ? 'selected' : '' }}>Animal</option>
                                        <option value="educational" {{ request('category') == 'educational' ? 'selected' : '' }}>Educacional</option>
                                    </select>
                                </div>

                                <!-- Data -->
                                <div class="col-lg-3 col-md-6">
                                    <label class="form-label fw-semibold">Data do Evento</label>
                                    <input type="date" 
                                           name="date" 
                                           class="form-control filter-select" 
                                           value="{{ request('date') }}">
                                </div>

                                <!-- Botão Aplicar -->
                                <div class="col-lg-1 col-md-6">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Contador e Limpar Filtros -->
                            <div class="filter-actions mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="filter-results">
                                        <span class="text-muted">
                                            <strong>{{ $actions->total() }}</strong> ações encontradas
                                        </span>
                                    </div>
                                    <div class="d-flex gap-2">
                                        @if(request()->hasAny(['search', 'category', 'date']))
                                        <a href="{{ route('actions.index') }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-undo me-1"></i>Limpar filtros
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Lista de ações --}}
            @if ($actions->isEmpty())
                <div class="text-center py-5 my-5">
                    <div class="empty-state bg-white rounded-3 p-5 shadow-sm">
                        <i class="fas fa-inbox fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Não foram encontradas ações voluntárias.</h5>
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
    </div>
</div>

<script>
// Funcionalidade para limpar filtros individualmente
document.addEventListener('DOMContentLoaded', function() {
    // Limpar campo de pesquisa individualmente
    const searchInput = document.querySelector('input[name="search"]');
    
    // Só criar o botão se o input existir
    if (searchInput) {
        
        clearSearch.className = 'btn-clear-search';
        
        searchInput.parentNode.style.position = 'relative';
        searchInput.parentNode.appendChild(clearSearch);
        
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            clearSearch.style.display = 'none';
            document.getElementById('filter-form').submit();
        });
        
        searchInput.addEventListener('input', function() {
            clearSearch.style.display = this.value ? 'flex' : 'none';
        });
    }
    
    // Auto-submit ao alterar selects (opcional)
    const selects = document.querySelectorAll('select[name="category"], select[name="date"]');
    selects.forEach(select => {
        select.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    });
});
</script>
@endsection