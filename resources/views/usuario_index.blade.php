@extends('master')

@section('corpo')
    
    <h2>Usuários</h2>
    <table class="table table-hover text-center">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nome</th>
                @canany(['update', 'view'], App\Models\Usuario::class)
                    <th scope="col">Ações</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
            <tr>
                <th scope="row">{{ $usuario->id }}</th>
                <td>
                    {{ $usuario->primeiro_nome. ' ' .$usuario->sobrenome }}
                </td>
                <td>
                    @can('view', $usuario)
                        <button class="btn btn-info" type="button" onclick="location.href='{{ route('usuario.show', ['usuario'=>$usuario->id]) }}'">Visualizar</button>
                    @endcan
                    @can('update', $usuario)
                        <button class="btn btn-dark" type="button" onclick="location.href='{{ route('usuario.edit', ['usuario'=>$usuario->id]) }}'">Editar</button>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @can('create', App\Models\Usuario::class)
        <a href="{{ route('usuario.create') }}" class="btn btn-primary">Criar usuário</a>
    @endcan
    
    <a href="{{ route('relatorio.show', ['relatorio' => 'usuarios']) }}" class="btn btn-secondary">Exportar usuários</a>
    
    @if (session()->has('mensagem'))
        <p><strong>{{ session()->get('mensagem') }}</strong></p>
    @endif
@endsection