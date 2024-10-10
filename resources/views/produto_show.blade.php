@extends('master')

@section('corpo')
    <h2>Detalhes do produto</h2>
    @can('view', $produto)
        <p><strong>ID: </strong>{{$produto->id}}</p>
        <p><strong>Código: </strong>{{$produto->codigo}}</p>
        <p><strong>Produto: </strong>{{$produto->produto}}</p>
        <p><strong>Descrição: </strong>{{$produto->descricao}}</p>
        <p><strong>Ativo: </strong>{{$produto->ativo === 1 ? 'Sim' : 'Não'}}</p>
        <p><strong>Em estoque: </strong>{{$produto->ativo === 1 ? 'Sim' : 'Não'}}</p>
        <p><strong>Criado em: </strong>{{date_format($produto->created_at, 'd/m/Y H:i:s')}}</p>
        <p><strong>Atualizado em: </strong>{{date_format($produto->updated_at, 'd/m/Y H:i:s')}}</p>
        <p><strong>Cadastrado por: </strong>{{$produto->usuario_inclusao}}</p>
        <p><strong>Atualizado última vez por: </strong>{{$produto->usuario_alteracao}}</p>
    @endcan
    <a class="btn btn-primary" href="{{ route('produto.index') }}">Voltar</a>
@endsection