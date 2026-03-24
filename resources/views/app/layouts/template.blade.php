<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>@yield('title') | Voluntariar</title>

    <!-- Bootstrap CSS (apenas UMA vez e versão correspondente ao JS) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Seu CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @yield('css')
</head>

<body class="d-flex flex-column min-vh-100">

    @if(empty($hideNavbar))
        @include('app.components.navbar')
    @endif

    <main class="flex-grow-1">
        @yield('content')
    </main>

    @include('app.components.footer')

    <!-- Bootstrap JS (APENAS UMA VEZ, MESMA VERSÃO DO CSS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>
</html>
