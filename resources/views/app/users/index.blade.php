@extends('app.layouts.template')

@section('title', 'Usuários')

@section('content')
<div class="container-fluid px-4 mt-4 p-5">

    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 fw-bold mb-1" style="color: var(--text-dark);">Lista de Usuários</h1>
                    <p class="text-muted mb-0">Gerencie todos os usuários do sistema</p>
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
                    <form method="GET" action="{{ route('users.index') }}" class="row g-3 align-items-end">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">Nome</label>
                            <input type="text" name="name" class="form-control rounded-2" placeholder="Buscar por nome" value="{{ request('name') }}">
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">E-mail</label>
                            <input type="text" name="email" class="form-control rounded-2" placeholder="Buscar por e-mail" value="{{ request('email') }}">
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <label class="form-label fw-semibold small text-muted mb-2">Tipo</label>
                            <select name="type" class="form-select rounded-2">
                                <option value="">Todos os tipos</option>
                                <option value="user" {{ request('type') == 'user' ? 'selected' : '' }}>Usuário</option>
                                <option value="ong" {{ request('type') == 'ong' ? 'selected' : '' }}>ONG</option>
                                <option value="admin" {{ request('type') == 'admin' ? 'selected' : '' }}>Administrador</option>
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="d-grid gap-2 d-md-flex">
                                <button class="btn btn-primary rounded-2 fw-semibold flex-fill" type="submit">
                                    <i class="fas fa-filter me-2"></i>Filtrar
                                </button>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary rounded-2 fw-semibold flex-fill">
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
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">Usuário</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">E-mail</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0">Tipo</th>
                                    <th class="px-4 py-3 fw-semibold text-muted border-0 text-center" style="width: 200px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr class="border-top">
                                        <td class="px-4 py-3 border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar bg-primary bg-opacity-10 rounded-2 d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-primary fs-6"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-semibold text-dark">{{ $user->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <span class="text-muted">{{ $user->email }}</span>
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            @if($user->role === 'admin')
                                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-2">
                                                    <i class="fas fa-crown me-1"></i>Administrador
                                                </span>
                                            @elseif($user->role === 'ong')
                                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-2">
                                                    <i class="fas fa-hands-helping me-1"></i>ONG
                                                </span>
                                            @elseif($user->role === 'user')
                                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-2">
                                                    <i class="fas fa-user me-1"></i>Usuário
                                                </span>
                                            @else
                                                <!-- Fallback para valores desconhecidos -->
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2 rounded-2">
                                                    {{ $user->role ?? 'Desconhecido' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 border-0">
                                            <div class="d-flex justify-content-center gap-2">

                                                <!-- Botão Excluir -->
                                                <form action="{{ route('users.destroy', $user) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-outline-danger btn-sm rounded-2 fw-semibold px-3"
                                                            title="Excluir usuário">
                                                        <i class="fas fa-trash me-1"></i>Excluir
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-5 text-center border-0">
                                            <div class="empty-state">
                                                <i class="fas fa-users fs-1 text-muted mb-3"></i>
                                                <h5 class="text-muted mb-2">Nenhum usuário encontrado</h5>
                                                <p class="text-muted small">Tente ajustar os filtros de busca</p>
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

</div>
@endsection