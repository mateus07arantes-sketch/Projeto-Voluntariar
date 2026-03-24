@extends('app.layouts.template')

@section('title', 'Aguardando Aprovação')

@section('content')

<div class="container-fluid min-vh-100 d-flex align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card p-5 shadow-lg rounded-4">
                <div class="card-body">

                @if(isset($message))
                    <i class="fas fa-check-circle fa-4x text-success mb-4"></i>
                    <h2 class="text-success mb-3">Cadastro Aprovado!</h2>
                    <p class="text-muted mb-4">{{ $message }}</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Ir para Login</a>

                @elseif(session('rejected'))
                    <i class="fas fa-times-circle fa-4x text-danger mb-4"></i>
                    <h2 class="text-danger mb-3">Cadastro Recusado</h2>
                    <p class="text-muted">Os administradores do sistema identificaram um erro na tentativa de cadastrar sua Organização</p>
                    <p class="text-muted">Você pode tentar novamente enviando um novo cadastro.</p>
                    <a href="{{ route('ongs.create') }}" class="btn btn-secondary mt-3">Fazer novo cadastro</a>

                @else
                    <i class="fas fa-clock fa-4x text-warning mb-4"></i>
                    <h2 class="text-primary mb-3">Cadastro em Análise</h2>
                    <p class="text-muted mb-4">
                        Seu cadastro foi recebido e está aguardando aprovação do administrador.
                        Você receberá um e-mail quando sua conta for ativada.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Voltar para Login</a>
                @endif
            </div>
        </div>
    </div>
</div>

</div>
@endsection
