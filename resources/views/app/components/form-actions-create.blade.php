<div class="container-fluid action-container p-5">
        <div class="row w-100 justify-content-center">
            <div class="col-xxl-10 col-12">
                <div class="card action-card">
                    <!-- Cabeçalho com a paleta de cores do sistema -->
                    <div class="action-header">
                        <div class="action-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h2 class="fw-bold mb-2">Cadastrar Nova Ação Voluntária</h2>
                        <p class="mb-0 opacity-90">Crie uma oportunidade para fazer a diferença na sua comunidade</p>
                    </div>

                <!-- Corpo do formulário -->
                <div class="action-body">
                    <form action="{{ route('actions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Seção: Informações Básicas -->
                        <div class="mb-4">
                            <h4 class="section-title">
                                <i class="fas fa-info-circle"></i> Informações Básicas
                            </h4>
                            
                            <!-- Título -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Título da ação</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="Ex: Mutirão de limpeza na praça central">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Categoria -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Categoria</label>
                                <select name="category" id="category" class="form-select @error('category') is-invalid @enderror">
                                    <option value="">Selecione uma categoria</option>
                                    <option value="environmental" {{ old('category') == 'environmental' ? 'selected' : '' }}>Ambiental</option>
                                    <option value="social" {{ old('category') == 'social' ? 'selected' : '' }}>Social</option>
                                    <option value="animal" {{ old('category') == 'animal' ? 'selected' : '' }}>Animal</option>
                                    <option value="educational" {{ old('category') == 'educational' ? 'selected' : '' }}>Educacional</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Descrição -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Descreva os objetivos, atividades e impacto da ação...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Seção: Localização e Data -->
                        <div class="mb-4">
                            <h4 class="section-title">
                                <i class="fas fa-map-marker-alt"></i> Localização e Data
                            </h4>
                            
                            <!-- Localização -->
                            <div class="mb-3">
                                <label for="location" class="form-label">Localização</label>
                                <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror"
                                        value="{{ old('location') }}" placeholder="Ex: Rua das Flores, 123 - Centro, Batatais">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Data e hora e Vagas -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="event_datetime" class="form-label">Data e hora do evento</label>
                                    <input type="datetime-local" name="event_datetime" id="event_datetime"
                                            class="form-control @error('event_datetime') is-invalid @enderror"
                                            value="{{ old('event_datetime') }}">
                                    @error('event_datetime')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="vacancies" class="form-label">Número de vagas</label>
                                    <input type="number" name="vacancies" id="vacancies" min="0"
                                            class="form-control @error('vacancies') is-invalid @enderror"
                                            value="{{ old('vacancies') }}" placeholder="Ex: 15">
                                    @error('vacancies')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                       <!-- Seção: Imagem -->
<div class="mb-4">
    <h4 class="section-title">
        <i class="fas fa-image"></i> Imagem Ilustrativa
    </h4>
    
    <div class="mb-3">
        <label for="image" class="form-label">Selecione uma imagem</label>
        <input type="file" name="image" id="image" accept="image/*"
                class="form-control @error('image') is-invalid @enderror">
        @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        <!-- Mensagem de imagem anterior -->
        <div id="previous-image-message" class="alert alert-info mt-2 py-2" style="display: none;">
            <i class="fas fa-info-circle"></i>
            <span id="previous-image-text"></span>
        </div>
        
        <div class="form-text">Formatos aceitos: JPG, JPEG, PNG, GIF, WEBP — até 4MB.</div>
    </div>
    
    <!-- Preview da imagem -->
    <div class="image-preview">
        <div class="image-preview-placeholder">
            <i class="fas fa-cloud-upload-alt"></i>
            <p>Pré-visualização da imagem aparecerá aqui</p>
        </div>
    </div>
</div>
                        <!-- Botões -->
                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('actions.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i> Voltar
                            </a>
                            <button type="submit" class="btn-action">
                                <i class="fas fa-save me-2"></i> Cadastrar Ação
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview da imagem selecionada
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.querySelector('.image-preview');
        const placeholder = document.querySelector('.image-preview-placeholder');
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
                
                let img = preview.querySelector('img');
                if (!img) {
                    img = document.createElement('img');
                    preview.appendChild(img);
                }
                
                img.src = e.target.result;
                img.style.display = 'block';
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            if (placeholder) {
                placeholder.style.display = 'block';
            }
            
            const img = preview.querySelector('img');
            if (img) {
                img.style.display = 'none';
            }
        }
    });

    
</script>