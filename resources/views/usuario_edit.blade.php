@extends('master')

@section('corpo')
    <h2>Edição de Usuário</h2>
    <form action="{{ route('usuario.update', ['usuario' => $usuario->id]) }}" method="POST">
        @can('update', $usuario)
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="primeiro_nome">Primeiro nome</label>
                <input class="form-control" type="text" name="primeiro_nome" id="primeiro_nome" value="{{$usuario->primeiro_nome}}">
                <label for="sobrenome">Sobrenome</label>
                <input class="form-control" type="text" name="sobrenome" id="sobrenome" value="{{$usuario->sobrenome}}">
                <label for="email">E-mail</label>
                <input class="form-control" type="email" name="email" id="email" value="{{$usuario->email}}">
                <label for="ativo">Ativo?</label>
                <select class="form-control" name="ativo" id="ativo">
                    <option value="1" {{$usuario->ativo == 1 ? 'selected' : ''}}>Sim</option>
                    <option value="0" {{$usuario->ativo == 0 ? 'selected' : ''}}>Não</option>
                </select>
            </div>
            <input class="btn btn-dark" type="submit" value="Atualizar">
        @endcan
        <a class="btn btn-primary" href="{{ route('usuario.index') }}">Voltar</a>
    </form>
@endsection