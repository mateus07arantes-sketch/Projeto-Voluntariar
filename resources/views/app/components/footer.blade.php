<footer class="footer mt-5">
    <div class="container">
        <div class="row">
            <!-- Links Úteis -->
            <div class="col-md-3 mb-4">
                <h5 class="fw-bold">Links Úteis</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        {{-- <a href="{{ route('welcome') }}">
                            <i class="fas fa-home me-2"></i>Início
                        </a> --}}
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-inbox me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('actions.index') }}">
                            <i class="fas fa-hands-helping me-2"></i>Ações Voluntárias
                        </a>
                    </li>
                    @auth
                    <li class="mb-2">
                        <a href="{{ route('user.edit') }}">
                            <i class="fas fa-user-edit me-2"></i>Meu Perfil
                        </a>
                    </li>
                    @else
                    <li class="mb-2">
                        <a href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>

            <!-- Sobre Nós -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Sobre o Voluntariar</h5>
                <p class="small" style="line-height: 1.5;">
                    Sistema desenvolvido como Trabalho de Conclusão de Curso (TCC) para conectar voluntários 
                    com oportunidades de ações sociais. Plataforma que facilita o encontro entre pessoas 
                    dispostas a ajudar e instituições que necessitam de apoio voluntário.
                </p>
                <div class="mt-3">
                    <a href="{{ route('user.create') }}" class="btn-volunteer-footer">
                        <i class="fas fa-user-plus me-1"></i>Cadastre-se como Voluntário
                    </a>
                </div>
            </div>

            <!-- Membros do Grupo -->
            <div class="col-md-5 mb-4">
                <h5 class="fw-bold">Desenvolvido por</h5>
                <div class="members-section">
                    <p class="small mb-2">
                        <!-- COLOQUE AQUI OS NOMES DOS MEMBROS DO GRUPO -->
                        [Alanna] <br>
                        [Ana Julia] <br>
                        [Gabriel] <br>
                        [Mateus] 
                    </p>
                    <div class="contact-info mt-3">
                        <p class="small mb-1">
                            <i class="fas fa-university me-2"></i>Instituição de Ensino - SENAI
                        </p>
                        <p class="small mb-1">
                            <i class="fas fa-graduation-cap me-2"></i>Curso: [Análise e desenvolvimento de sistemas]
                        </p>
                        <p class="small">
                            <i class="fas fa-map-marker-alt me-2"></i>Batatais, SP
                        </p>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2025 Voluntariar - Plataforma de Voluntariado</p>
            <div>
                <span class="small">Trabalho de Conclusão de Curso</span>
            </div>
        </div>
    </div>
</footer>