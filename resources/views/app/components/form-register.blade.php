<div class="container-fluid register-container p-5">
    <div class="row w-100 justify-content-center">
        <div class="col-xxl-10 col-12">
            <div class="card register-card">
                <div class="row g-0">

                    <!-- LADO ESQUERDO -->
                    <div class="col-lg-6 col-md-6 d-none d-md-block">
                        <div class="register-left">
                            <div class="register-brand">
                                <div class="register-brand-icon">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                                <div class="register-brand-text fs-4 fw-bold">Voluntariar</div>
                            </div>

                            <h1 class="fw-bold">Junte-se a nós</h1>
                            <p class="mb-4">Faça parte da mudança e transforme vidas através do voluntariado.</p>

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
                        <div class="register-right">

                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Crie sua conta</h2>
                                <p class="text-muted">Preencha os dados abaixo para se cadastrar</p>
                            </div>

                            {{-- Mensagem de Sucesso --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <div class="flex-grow-1">{{ session('success') }}</div>
                                </div>
                            @endif

                            <form action="{{ route('user.store') }}" method="POST">
                                @csrf

                                {{-- Nome --}}
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Nome Completo</label>
                                    <input type="text" name="name" id="name" 
                                           value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="Digite seu nome completo">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- E-mail --}}
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">E-mail</label>
                                    <input type="email" name="email" id="email" 
                                           value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="exemplo@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Senha --}}
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-semibold">Senha</label>
                                    <input type="password" name="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Digite sua senha">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Confirmação de Senha --}}
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold">Confirmar Senha</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" 
                                           class="form-control" 
                                           placeholder="Confirme sua senha">
                                </div>

                                <button type="submit" class="btn-register">
                                    <i class="fas fa-user-plus me-2"></i> Cadastrar
                                </button>

                                <div class="text-center mt-4 pt-3">
                                    <p class="mb-2">
                                        Já tem uma conta?
                                        <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-none ms-1">
                                            Fazer login
                                        </a>
                                    </p>
                                    <p class="mb-0">
                                        É uma organização?
                                        <a href="{{ route('ongs.create') }}" class="fw-semibold text-primary text-decoration-none ms-1">
                                            Cadastrar ONG
                                        </a>
                                    </p>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>