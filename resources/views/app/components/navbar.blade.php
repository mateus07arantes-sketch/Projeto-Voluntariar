<nav class="navbar navbar-expand-lg modern-navbar shadow-sm" style="background: var(--neutral) !important;">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
      <img src="{{ asset('images/logo_certo.png') }}" alt="Logo Voluntariar" width="42" height="42" class="logo me-2">
      <span class="brand-text fw-bold" style="color: var(--text-dark);">Voluntariar</span>
    </a>

    <!-- Mobile Toggle -->
    <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars" style="color: var(--text-dark);"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Links principais centralizados -->
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-3">
        @auth
          <li class="nav-item">
            <a class="nav-link nav-link-modern position-relative" href="{{ route('dashboard') }}">
              <i class="fa-solid fa-inbox me-2"></i>Dashboard
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link nav-link-modern dropdown-toggle position-relative" href="#" id="actionsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fas fa-hands-helping me-1"></i>Ações
            </a>
            <ul class="dropdown-menu dropdown-modern" aria-labelledby="actionsDropdown">
              @can('create', App\Models\VoluntaryAction::class)
                <li>
                  <a class="dropdown-item dropdown-item-modern" href="{{ route('actions.create') }}">
                    <i class="fas fa-plus-circle me-2"></i>Cadastrar Ação
                  </a>
                </li>
              @endcan
              @can('viewAny', App\Models\VoluntaryAction::class)
                <li>
                  <a class="dropdown-item dropdown-item-modern" href="{{ route('actions.index') }}">
                    <i class="fas fa-eye me-2"></i>Visualizar Ações
                  </a>
                </li>
              @endcan
              
              <!-- Link Minhas Ações - Apenas para ONGs -->
              @if(auth()->check() && auth()->user()->hasRole(\App\Enums\Role::Ong))
                <li><hr class="dropdown-divider my-2"></li>
                <li>
                  <a class="dropdown-item dropdown-item-modern" href="{{ route('actions.ong.history') }}">
                    <i class="fas fa-history me-2"></i>Minhas Ações
                  </a>
                </li>
              @endif
            </ul>
          </li>

          @can('viewAny', App\Models\User::class)
            <li class="nav-item">
              <a class="nav-link nav-link-modern position-relative" href="{{ route('users.index') }}">
                <i class="fas fa-users me-1"></i>Usuários
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link nav-link-modern position-relative" href="{{ route('ongs.pending') }}">
                <i class="fas fa-cog me-1"></i>Painel Admin
              </a>
            </li>
          @endcan
        @endauth
      </ul>

      <!-- Menu do usuário à direita -->
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center user-menu-modern" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="user-avatar me-2">
                <i class="fas fa-user-circle"></i>
              </div>
              <span class="user-name">{{ auth()->user()->name }}</span>
              <i class="fas fa-chevron-down ms-2 small"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end dropdown-modern" aria-labelledby="userMenu" style="z-index: 1050;">
              <li>
                <a class="dropdown-item dropdown-item-modern" href="{{ route('user.edit') }}">
                  <i class="fas fa-user-edit me-2"></i>Editar Perfil
                </a>
              </li>

              @if(auth()->check() && auth()->user()->hasRole(\App\Enums\Role::User, \App\Enums\Role::Admin))
              <li>
                <a class="dropdown-item dropdown-item-modern" href="{{ route('registrations.index') }}">
                  <i class="fas fa-list-check me-2"></i>Minhas Inscrições
                </a>
              </li>
              @endif

              <!-- Link Minhas Ações também no menu do usuário para fácil acesso -->
              @if(auth()->check() && auth()->user()->hasRole(\App\Enums\Role::Ong))
                <li>
                  <a class="dropdown-item dropdown-item-modern" href="{{ route('actions.ong.history') }}">
                    <i class="fas fa-history me-2"></i>Minhas Ações
                  </a>
                </li>
              @endif

              <li><hr class="dropdown-divider my-2"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                  @csrf
                  <button type="submit" class="dropdown-item dropdown-item-modern">
                    <i class="fas fa-sign-out-alt me-2"></i>Sair
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <div class="d-flex gap-2">
            <li class="nav-item">
              <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">
                <i class="fas fa-sign-in-alt me-1"></i>Entrar
              </a>
            </li>
            <li class="nav-item">
              <a class="btn btn-primary btn-sm" href="{{ route('user.create') }}">
                <i class="fas fa-user-plus me-1"></i>Cadastrar
              </a>
            </li>
          </div>
        @endauth
      </ul>
    </div>    
  </div>
</nav>