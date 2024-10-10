@extends('master')

@section('corpo')
    <h2>Usuário</h2>
    <form action="{{ route('usuario.destroy', ['usuario'=>$usuario->id]) }}" method="post">
        @can('view', $usuario)
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <p><strong>ID: </strong>{{$usuario->id}}</p>
            <p><strong>Nome / Sobrenome: </strong>{{$usuario->primeiro_nome.' '.$usuario->sobrenome}}</p>
            <p><strong>Email: </strong>{{$usuario->email}}</p>
            <p><strong>Ativo: </strong>{{$usuario->ativo === 1 ? 'Sim' : 'Não'}}</p>
            <p><strong>Criado em: </strong>{{date_format($usuario->created_at, 'd/m/Y H:i:s')}}</p>
            <p><strong>Atualizado em: </strong>{{date_format($usuario->updated_at, 'd/m/Y H:i:s')}}</p>
        @endcan
        @can('delete', $usuario)
            <input class="btn btn-warning" type="submit" value="Excluir">
        @endcan
        <a class="btn btn-primary" href="{{ route('usuario.index') }}">Voltar</a>
    </form>
@endsection