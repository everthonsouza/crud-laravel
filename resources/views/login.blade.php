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
<body class="container bg-dark text-light" style="margin: 10ch">
    <h1 class="text-center">Sistema de Cadastro</h1>
    <div class="d-flex justify-content-center text-center">
        <form class="form-group" action="{{ route('login.store') }}" method="POST">
            @csrf
            <label for="email">Usuário</label>
            <input class="form-control" type="text" name="email" id="email" placeholder="Seu e-mail">
            <label for="senha">Senha</label>
            <input class="form-control" type="password" name="senha" id="senha" placeholder="Sua senha">
            @error('email')
                <span class="text-warning">{{$message}}</span><br>
            @enderror
            @error('senha')
                <span class="text-warning">{{$message}}</span><br>
            @enderror
            @error('error')
                <span class="text-danger">{{$message}}</span><br>
            @enderror
            <input class="btn btn-primary" style="width: 100%" type="submit" value="Entrar">
        </form>
    </div>
</body>
</html>