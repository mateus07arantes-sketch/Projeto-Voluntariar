<section class="hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 hero-content">
                <h1 class="hero-title">Voluntariar</h1>
                <h2 class="hero-subtitle">Encontre sua causa. Faça a diferença.</h2>
                <p class="hero-description">
                    Conectamos pessoas que querem ajudar com organizações que precisam de apoio.
                    Descubra oportunidades de voluntariado em Batatais-SP e transforme sua vontade de fazer o bem em ação concreta.
                </p>
                
               <!-- Primeira linha: Ações principais -->
                <div class="hero-buttons p-2" style="display: flex; justify-content: center; gap: 10px;">
                    <a href="{{ route('user.create') }}" class="btn btn-hero btn-primary-custom">Quero ser voluntário</a>
                    <a href="{{ route('ongs.create') }}" class="btn btn-hero btn-primary-custom">Cadastrar minha ONG</a>
                </div>

                <!-- Segunda linha: Acesso para quem já tem conta -->
                <div style="display: flex; justify-content: center; margin-top: 15px;">
                    <div style="width: calc(100% / 2); display: flex; justify-content: center;">
                        <a href="{{ route('login') }}" class="btn btn-hero btn-outline-custom" style="width: 300px; max-width: 100%;">
                            Já tenho conta
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center hero-image">
                <img src="{{ asset('images/welcome_gif_certo.gif') }}" alt="Pessoas fazendo trabalho voluntário" class="img-fluid" style="background: linear-gradient(135deg, var(--light) 0%, #ffffff 100%)">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <h2 class="large-section-title text-center large-title">Como funciona</h2>
        <p class="section-subtitle">Três passos simples para começar a fazer a diferença</p>
       
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h3 class="feature-title">Crie seu perfil</h3>
                    <p class="feature-description">
                        Cadastre-se em minutos informando suas habilidades, interesses e disponibilidade. É rápido, simples e seguro.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="feature-title">Encontre oportunidades</h3>
                    <p class="feature-description">
                        Explore diversas causas e encontre ações voluntárias que combinam com você, perto da sua localização.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3 class="feature-title">Faça a diferença</h3>
                    <p class="feature-description">
                        Participe das ações, conecte-se com outras pessoas e transforme realidades na sua comunidade.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Causes Section -->
<section class="causes">
    <div class="container">
        <h2 class="large-section-title text-center large-title">Nossas Causas</h2>
        <p class="section-subtitle">Descubra oportunidades que combinam com seus valores e paixões</p>
       
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="cause-card">
                    <div class="cause-header">
                        <div class="cause-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3>Meio Ambiente</h3>
                    </div>
                    <div class="cause-body">
                        <p>Participe de ações de preservação ambiental, reflorestamento, limpeza de áreas verdes e educação ecológica.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="cause-card">
                    <div class="cause-header">
                        <div class="cause-icon">
                            <i class="fas fa-paw"></i>
                        </div>
                        <h3>Causa Animal</h3>
                    </div>
                    <div class="cause-body">
                        <p>Ajuda a abrigos, resgate de animais, campanhas de adoção responsável e conscientização sobre bem-estar animal.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="cause-card">
                    <div class="cause-header">
                        <div class="cause-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3>Educação</h3>
                    </div>
                    <div class="cause-body">
                        <p>Apoio escolar, alfabetização de adultos, oficinas profissionalizantes e incentivo à leitura e educação.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="cause-card">
                    <div class="cause-header">
                        <div class="cause-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h3>Assistência Social</h3>
                    </div>
                    <div class="cause-body">
                        <p>Distribuição de alimentos, apoio a abrigos, assistência a idosos e pessoas em situação de vulnerabilidade.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta mb-5">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">Pronto para fazer a diferença?</h2>
            <p class="cta-description">
                Junte-se a milhares de voluntários que já estão transformando Batatais.
                Sua ajuda é fundamental para construir uma comunidade mais solidária e acolhedora.
            </p>
            <a href="{{ route('user.create') }}" class="btn btn-cta">Comece Agora</a>
        </div>
    </div>
</section>