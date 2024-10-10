@extends('master')

@section('corpo')
    
    <h2>Cadastro de Produto</h2>
    <form action="{{ route('produto.store') }}" method="POST">
        @can('create', App\Models\Produto::class)
            @csrf
            <div class="form-group">
                <label for="codigo">Código</label>
                <input class="form-control" type="text" name="codigo" id="codigo" placeholder="Código do produto">
                <label for="produto">Produto</label>
                <input class="form-control" type="text" name="produto" id="produto" placeholder="Nome do produto">
                <label for="descricao">Descrição</label>
                <textarea class="form-control" name="descricao" id="descricao" cols="30" rows="10" placeholder="Descreva o produto..."></textarea>
                <label for="em_estoque">Em estoque?</label>
                <select class="form-control" name="em_estoque" id="em_estoque">
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>
            <input class="btn btn-dark" type="submit" value="Salvar">
        @endcan
        <a class="btn btn-primary" href="{{ route('produto.index') }}">Voltar</a>
    </form>

@endsection