<div class="container-fluid">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 100%; max-width: 600px;">
            <h2 class="text-center mb-4 fw-bold text-primary">Editar informações da ONG</h2>

            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('ongs.update', $ong->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Nome da ONG -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nome da ONG</label>
                    <input type="text" name="name" id="name" class="form-control" 
                           value="{{ old('name', $ong->name) }}" required>
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- E-mail da ONG -->
                <div class="mb-3">
                    <label for="email" class="form-label">E-mail institucional</label>
                    <input type="email" name="email" id="email" class="form-control"
                           value="{{ old('email', $ong->email) }}" required>
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Telefone -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="text" name="phone" id="phone" class="form-control" 
                           value="{{ old('phone', $ong->phone) }}" placeholder="Ex: (11) 98765-4321">
                    @error('phone') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Endereço -->
                <div class="mb-3">
                    <label for="address" class="form-label">Endereço</label>
                    <input type="text" name="address" id="address" class="form-control"
                           value="{{ old('address', $ong->address) }}" placeholder="Rua, número, bairro, cidade">
                    @error('address') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Descrição -->
                <div class="mb-3">
                    <label for="description" class="form-label">Descrição</label>
                    <textarea name="description" id="description" rows="4" class="form-control"
                              placeholder="Fale sobre a missão e os projetos da ONG...">{{ old('description', $ong->description) }}</textarea>
                    @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <!-- Botão -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary w-100 fw-semibold">
                        <i class="bi bi-save me-2"></i>Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
