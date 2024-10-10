@extends('master')

@section('corpo')
    
    <h2>Criação de Usuário</h2>
    <form action="{{ route('usuario.store') }}" method="POST">
        @can('create', App\Models\Usuario::class)
            @csrf
            <div class="form-group">
                <label for="primeiro_nome">Primeiro nome</label>
                <input class="form-control" type="text" name="primeiro_nome" id="primeiro_nome" placeholder="Primeiro nome">
                <label for="sobrenome">Sobrenome</label>
                <input class="form-control" type="text" name="sobrenome" id="sobrenome" placeholder="Sobrenome">
                <label for="email">E-mail</label>
                <input class="form-control" type="email" name="email" id="email" placeholder="Seu e-mail">
                <label for="senha">Senha</label>
                <input class="form-control" type="password" name="senha" id="senha" placeholder="Sua senha">
            </div>
            <input class="btn btn-dark" type="submit" value="Salvar">
        @endcan
        <a class="btn btn-primary" href="{{ route('usuario.index') }}">Voltar</a>
    </form>
@endsection