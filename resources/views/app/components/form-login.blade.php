<div class="container-fluid login-container p-5">
    <div class="row w-100 justify-content-center">
        <div class="col-xxl-10 col-12">
            <div class="card login-card">
                <div class="row g-0">

                    <!-- LADO ESQUERDO -->
                    <div class="col-lg-6 col-md-6 d-none d-md-block">
                        <div class="login-left">
                            <div class="brand">
                                <div class="brand-icon">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                                <div class="brand-text-login fs-4 fw-bold">Voluntariar</div>
                            </div>

                            <h1 class="fw-bold">Faça a diferença</h1>
                            <p class="mb-4">Junte-se a milhares de voluntários transformando vidas.</p>

                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="fas fa-leaf me-2"></i> Proteja o meio ambiente</li>
                                <li class="mb-3"><i class="fas fa-paw me-2"></i> Cuide dos animais</li>
                                <li class="mb-3"><i class="fas fa-hands me-2"></i> Ofereça assistência social</li>
                                <li class="mb-3"><i class="fas fa-graduation-cap me-2"></i> Promova a educação</li>
                            </ul>
                        </div>
                    </div>

                    <!-- LADO DIREITO — FORMULÁRIO FUNCIONAL LARAVEL -->
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="login-right">

                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Bem-vindo de volta</h2>
                                <p class="text-muted">Entre com suas credenciais para continuar</p>
                            </div>

                            {{-- Mensagem de sucesso --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form action="{{ route('login') }}" method="POST">
                                @csrf

                                {{-- Email --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">E-mail</label>
                                    <input type="email" id="email" name="email"
                                           value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="seu.email@voluntariar.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Senha --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Senha</label>
                                    <input type="password" id="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Sua senha">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn-login">
                                    <i class="fas fa-sign-in-alt me-2"></i> Entrar
                                </button>

                                <p class="text-center mt-4 mb-0 pt-2">
                                    Não possui uma conta?
                                    <a href="{{ route('user.create') }}" class="fw-semibold text-primary text-decoration-none">
                                        Cadastre-se como voluntário
                                    </a>
                                </p>
                                <p class="text-center mt-3 mb-0">
                                    É uma ONG sem conta?
                                    <a href="{{ route('ongs.create') }}" class="text-decoration-none text-primary fw-semibold ms-1">
                                        Cadastre-se como organização
                                    </a>
                                </p>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>