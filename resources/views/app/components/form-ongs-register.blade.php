<div class="container-fluid register-container p-5">
    <div class="row w-100 justify-content-center">
        <div class="col-xxl-10 col-12">
            <div class="card register-card-ong">
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
                            <p class="mb-4">Conecte sua organização com pessoas dispostas a ajudar.</p>

                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="fas fa-leaf me-2"></i> Proteja o meio ambiente</li>
                                <li class="mb-3"><i class="fas fa-paw me-2"></i> Cuide dos animais</li>
                                <li class="mb-3"><i class="fas fa-hands me-2"></i> Ofereça assistência social</li>
                                <li class="mb-3"><i class="fas fa-graduation-cap me-2"></i> Promova a educação</li>
                            </ul>
                        </div>
                    </div>

                    <!-- LADO DIREITO — FORMULÁRIO ONG -->
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="register-right">

                            <div class="text-center mb-4">
                                <h2 class="fw-bold">Cadastro ONG</h2>
                                <p class="text-muted">Preencha todos os campos abaixo:</p>
                            </div>

                            {{-- Mensagem de Sucesso --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="fas fa-check-circle me-2"></i>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('ongs.store') }}" method="POST">
                                @csrf

                                {{-- Nome da ONG --}}
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Nome da ONG</label>
                                    <input type="text" name="name" id="name" 
                                        value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror" 
                                        placeholder="Digite o nome da ONG">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row g-3">
                                    {{-- CNPJ --}}
                                    <div class="col-md-6">
                                        <label for="cnpj" class="form-label fw-semibold">CNPJ</label>
                                        <input type="text" name="cnpj" id="cnpj" 
                                            value="{{ old('cnpj') }}"
                                            class="form-control @error('cnpj') is-invalid @enderror" 
                                            placeholder="00.000.000/0000-00"
                                            maxlength="18">
                                        @error('cnpj')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- E-mail --}}
                                    <div class="col-md-6">
                                        <label for="email" class="form-label fw-semibold">E-mail</label>
                                        <input type="email" name="email" id="email" 
                                            value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror" 
                                            placeholder="exemplo@email.com">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row g-3 mt-0">
                                    {{-- Senha --}}
                                    <div class="col-md-6">
                                        <label for="password" class="form-label fw-semibold">Senha</label>
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror" 
                                            placeholder="Digite sua senha">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Confirmação de Senha --}}
                                    <div class="col-md-6">
                                        <label for="password_confirmation" class="form-label fw-semibold">Confirmar Senha</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" 
                                            class="form-control" 
                                            placeholder="Confirme sua senha">
                                    </div>
                                </div>

                                {{-- Telefone --}}
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-semibold">Telefone</label>
                                    <input type="tel" name="phone" id="phone" 
                                        value="{{ old('phone') }}"
                                        class="form-control @error('phone') is-invalid @enderror" 
                                        placeholder="(00) 00000-0000">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Endereço --}}
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-semibold">Endereço</label>
                                    <input type="text" name="address" id="address" 
                                        value="{{ old('address') }}"
                                        class="form-control @error('address') is-invalid @enderror" 
                                        placeholder="Digite o endereço">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Descrição --}}
                                <div class="mb-4">
                                    <label for="description" class="form-label fw-semibold">Descrição</label>
                                    <textarea name="description" id="description" rows="3"
                                            class="form-control @error('description') is-invalid @enderror" 
                                            placeholder="Descreva sua ONG">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn-register">
                                    <i class="fas fa-building me-2"></i> Cadastrar ONG
                                </button>

                                <div class="text-center mt-4 pt-3">
                                    <p class="mb-2">
                                        Já tem uma conta?
                                        <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-none ms-1">
                                            Fazer login
                                        </a>
                                    </p>
                                    <p class="mb-0">
                                        É um voluntário?
                                        <a href="{{ route('user.create') }}" class="fw-semibold text-primary text-decoration-none ms-1">
                                            Cadastre-se
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

<script>
// Formatação em tempo real do CNPJ
document.getElementById('cnpj').addEventListener('input', function(e) {
    let input = e.target;
    let valor = input.value.replace(/\D/g, '');
    
    // Limita a 14 dígitos
    valor = valor.substring(0, 14);
    
    // Aplica a formatação
    if (valor.length <= 2) {
        input.value = valor;
    } else if (valor.length <= 5) {
        input.value = valor.replace(/^(\d{2})(\d+)/, '$1.$2');
    } else if (valor.length <= 8) {
        input.value = valor.replace(/^(\d{2})(\d{3})(\d+)/, '$1.$2.$3');
    } else if (valor.length <= 12) {
        input.value = valor.replace(/^(\d{2})(\d{3})(\d{3})(\d+)/, '$1.$2.$3/$4');
    } else {
        input.value = valor.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d+)/, '$1.$2.$3/$4-$5');
    }
});

// Formatação do telefone (opcional)
document.getElementById('phone')?.addEventListener('input', function(e) {
    let input = e.target;
    let valor = input.value.replace(/\D/g, '');
    
    // Limita a 11 dígitos
    valor = valor.substring(0, 11);
    
    // Aplica a formatação
    if (valor.length <= 2) {
        input.value = valor;
    } else if (valor.length <= 6) {
        input.value = valor.replace(/^(\d{2})(\d+)/, '($1) $2');
    } else if (valor.length <= 10) {
        input.value = valor.replace(/^(\d{2})(\d{4})(\d+)/, '($1) $2-$3');
    } else {
        input.value = valor.replace(/^(\d{2})(\d{5})(\d+)/, '($1) $2-$3');
    }
});
</script>