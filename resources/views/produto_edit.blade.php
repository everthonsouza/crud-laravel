@extends('master')

@section('corpo')
    <h2><strong>Edição de produto</strong> | ID {{$produto->id}}</h2> 
    <form action="{{ route('produto.update', ['produto' => $produto->id]) }}" method="POST">
        @can('update', $produto)
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group">
                <label for="codigo">Código</label>
                <input class="form-control" type="text" name="codigo" id="codigo" value="{{$produto->codigo}}">
                <label for="produto">Produto</label>
                <input class="form-control" type="text" name="produto" id="produto" value="{{$produto->produto}}">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" name="descricao" id="descricao" cols="30" rows="10">{{$produto->descricao}}</textarea>
                <label for="ativo">Ativo?</label>
                <select class="form-control" name="ativo" id="ativo">
                    <option value="1" {{$produto->ativo == 1 ? 'selected' : ''}}>Sim</option>
                    <option value="0" {{$produto->ativo == 0 ? 'selected' : ''}}>Não</option>
                </select>
                <label for="em_estoque">Em estoque?</label>
                <select class="form-control" name="em_estoque" id="em_estoque">
                    <option value="1" {{$produto->em_estoque == 1 ? 'selected' : ''}}>Sim</option>
                    <option value="0" {{$produto->em_estoque == 0 ? 'selected' : ''}}>Não</option>
                </select>
            </div>
            <input class="btn btn-dark" type="submit" value="Atualizar">
        @endcan
        <a class="btn btn-primary" href="{{ route('produto.index') }}">Voltar</a>
    </form>
@endsection