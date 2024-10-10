<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <title>Sistema de Cadastro</title>
</head>
<body>
    @if (auth()->check())
        @include('menu')
        <div class="container">
            @yield('corpo')
        </div>
    @else
        <div class="d-flex justify-content-center text-center">
            <h2 class="text-danger">Para acessar essa página você deve estar logado!
                <br><a href="{{ route('login.index') }}">Ir para o login</a>
            </h2>
        </div>    
    @endif
</body>
</html>