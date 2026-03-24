<div class="container-fluid action-container p-5">
    <div class="row w-100 justify-content-center">
        <div class="col-xxl-10 col-12">
            <div class="card action-card">
                <!-- Cabeçalho com a paleta de cores do sistema -->
                <div class="action-header">
                    <div class="action-icon">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <h2 class="fw-bold mb-2">Editar Perfil</h2>
                    <p class="mb-0 opacity-90">Atualize suas informações pessoais</p>
                </div>

                <!-- Corpo do formulário -->
                <div class="action-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('user.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Seção: Informações Pessoais -->
                        <div class="mb-4">
                            <h4 class="section-title">
                                <i class="fas fa-user-circle"></i> Informações Pessoais
                            </h4>
                            
                            <!-- Nome -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}"
                                       placeholder="Digite seu nome completo">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" name="email" id="email" 
                                       class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}"
                                       placeholder="seu.email@exemplo.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Seção: Segurança -->
                        <div class="mb-4">
                            <h4 class="section-title">
                                <i class="fas fa-lock"></i> Segurança
                            </h4>
                            
                            <div class="alert alert-info bg-light border-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Preencha os campos abaixo apenas se desejar alterar sua senha.
                            </div>

                            <!-- Nova Senha -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Nova Senha</label>
                                <input type="password" name="password" id="password" 
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Deixe em branco para manter a senha atual">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Mínimo de 6 caracteres</div>
                            </div>

                            <!-- Confirmar Senha -->
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Nova Senha</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="form-control"
                                       placeholder="Repita a nova senha">
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between pt-3">
                          <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Voltar para dashboard
                          </a>
                            <button type="submit" class="btn-action">
                                <i class="fas fa-save me-2"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>