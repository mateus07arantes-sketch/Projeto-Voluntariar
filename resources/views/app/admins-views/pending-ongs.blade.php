@extends('app.layouts.template')

@section('title', 'ONGs Pendentes')

@section('content')
<div class="container-fluid px-4 mt-4 p-5">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1" style="color: var(--text-dark);">ONGs Aguardando Aprovação</h1>
                    <p class="text-muted mb-0">Gerencie os cadastros de ONGs pendentes no sistema</p>
                </div>
            </div>
        </div>
    </div>

     <!-- Mensagem de Sucesso -->
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
                    <form method="GET" action="{{ route('ongs.pending') }}" class="row g-3 align-items-end">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">Nome</label>
                            <input type="text" name="name" class="form-control rounded-2" placeholder="Buscar por nome" value="{{ request('name') }}">
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">E-mail</label>
                            <input type="text" name="email" class="form-control rounded-2" placeholder="Buscar por e-mail" value="{{ request('email') }}">
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">CNPJ</label>
                            <input type="text" name="cnpj" class="form-control rounded-2" placeholder="Buscar por CNPJ" value="{{ request('cnpj') }}">
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="d-grid gap-2 d-md-flex">
                                <button class="btn btn-primary rounded-2 fw-semibold flex-fill" type="submit">
                                    <i class="fas fa-filter me-2"></i>Filtrar
                                </button>
                                <a href="{{ route('ongs.pending') }}" class="btn btn-outline-secondary rounded-2 fw-semibold flex-fill">
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
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">ONG</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">E-mail</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">CNPJ</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">Data de Cadastro</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0 text-center" style="width: 200px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ongs as $ong)
                                    <tr class="border-top">
                                        <td class="px-4 py-3 border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar bg-primary bg-opacity-10 rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    @if($ong->logo)
                                                        <img src="{{ asset('storage/' . $ong->logo) }}" 
                                                             alt="{{ $ong->name }}" 
                                                             class="rounded-2"
                                                             style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <i class="fas fa-hands-helping text-primary fs-6"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="fw-semibold text-dark">{{ $ong->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <span class="text-muted">{{ $ong->email }}</span>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <span class="text-muted">{{ $ong->cnpj }}</span>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <span class="text-muted">{{ $ong->created_at->format('d/m/Y H:i') }}</span>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Botão Visualizar -->
                                                <a href="{{ route('ongs.details', $ong) }}" 
                                                   class="btn btn-info btn-sm rounded-2 fw-semibold px-3"
                                                   title="Visualizar ONG">
                                                    <i class="fas fa-eye me-1"></i>Ver
                                                </a>

                                                <!-- Botão Aprovar -->
                                                <form action="{{ route('ongs.approve', $ong) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-success btn-sm rounded-2 fw-semibold px-3"
                                                            title="Aprovar ONG"
                                                            onclick="return confirm('Tem certeza que deseja aprovar esta ONG?')">
                                                        <i class="fas fa-check me-1"></i>Aprovar
                                                    </button>
                                                </form>

                                                <!-- Botão Rejeitar -->
                                                <form action="{{ route('ongs.reject', $ong) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-danger btn-sm rounded-2 fw-semibold px-3"
                                                            title="Rejeitar ONG"
                                                            onclick="return confirm('Tem certeza que deseja rejeitar esta ONG?')">
                                                        <i class="fas fa-times me-1"></i>Rejeitar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-5 text-center border-0">
                                            <div class="empty-state">
                                                <i class="fas fa-hands-helping fs-1 text-muted mb-3"></i>
                                                <h5 class="text-muted mb-2">Nenhuma ONG pendente</h5>
                                                <p class="text-muted small">Todas as ONGs foram revisadas ou não há registros para os filtros selecionados</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    @if($ongs->hasPages())
                    <div class="card-footer border-0 bg-transparent px-4 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="small text-muted mb-0">
                                Mostrando {{ $ongs->firstItem() }} a {{ $ongs->lastItem() }} de {{ $ongs->total() }} resultados
                            </p>
                            <div>
                                {{ $ongs->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.user-avatar {
    flex-shrink: 0;
    overflow: hidden;
}

.empty-state {
    padding: 2rem 1rem;
}

.table > :not(caption) > * > * {
    background-color: transparent;
}

.card-footer {
    border-top: 1px solid var(--bs-border-color);
}
</style>

@endsection