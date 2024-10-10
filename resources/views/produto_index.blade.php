@extends('master')

@section('corpo')

    <h2>Produtos</h2>
    <div class="table-responsive">
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Produto</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Em estoque?</th>
                    <th scope="col">Ativo?</th>
                    @can('view', App\Models\Produto::class)
                        <th scope="col">Detalhes</th>
                    @endcan
                    @can('update', App\Models\Produto::class)
                        <th scope="col">Editar</th>
                    @endcan
                    @can('delete', App\Models\Produto::class)
                        <th scope="col">Ações</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @foreach ($produtos as $produto)
                <tr>
                    <th scope="row">{{ $produto->id }}</th>
                    <td>{{ $produto->produto }}</td>
                    <td>{{ $produto->descricao }}</td>
                    <td>{{ $produto->em_estoque === 1 ? 'Sim' : 'Não' }}</td>
                    <td>{{ $produto->ativo === 1 ? 'Sim' : 'Não' }}</td>
                    @can('view', $produto)
                    <td>
                        <button class="btn btn-info" type="button" onclick="location.href='{{ route('produto.show', ['produto'=>$produto->id]) }}'"><i class="bi bi-folder2-open"></i></button>
                    </td>
                    @endcan
                    @can('update', $produto)
                    <td>
                        <button class="btn btn-dark" type="button" onclick="location.href='{{ route('produto.edit', ['produto'=>$produto->id]) }}'"><i class="bi bi-pen-fill"></i></button>
                    </td>
                    @endcan
                    @can('delete', $produto)
                    <td>
                        <form class="align-items-center" action="{{ route('produto.destroy', ['produto'=>$produto->id]) }}" method="post">
                            @csrf
                            @if ($produto->ativo === 1)
                                <button class="btn btn-secondary" style="width: 130px" type="submit"><i class='bi bi-trash'></i> Desativar</button>
                            @else
                                <button class="btn btn-secondary" style="width: 130px" type="submit"><i class='bi bi-check-lg'></i> Ativar</button>
                            @endif
                        </form>
                    </td>
                    @endcan
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @can('create', $produto)
        <a href="{{ route('produto.create') }}" class="btn btn-primary">Cadastrar produto</a>
    @endcan

    <a href="{{ route('relatorio.show', ['relatorio' => 'produtos', 'formato' => 'pdf']) }}" class="btn btn-secondary">Exportar em PDF</a>
    <a href="{{ route('relatorio.show', ['relatorio' => 'produtos', 'formato' => 'xlsx']) }}" class="btn btn-secondary">Exportar em Excel</a>

    @if (session()->has('mensagem'))
        <p><strong>{{ session()->get('mensagem') }}</strong></p>
    @endif
    
@endsection