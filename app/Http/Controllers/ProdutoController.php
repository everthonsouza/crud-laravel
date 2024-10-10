<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    public readonly Usuario $usuarioLogado;

    public function __construct() {
        $this->usuarioLogado = Auth::user();;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($this->usuarioLogado->cannot('view', Produto::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        $produtos = Produto::all();
        return view('produto_index', ['produtos' => $produtos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ($this->usuarioLogado->cannot('create', Produto::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        return view('produto_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->usuarioLogado->cannot('create', Produto::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        $produto = new Produto();
        $produto->produto = $request->produto;
        $produto->codigo = $request->codigo;
        $produto->descricao = $request->descricao;
        $produto->em_estoque = $request->em_estoque;
        $produto->usuario_id_inclusao = $this->usuarioLogado->id;
        $produto->usuario_id_alteracao = null;

        $salvou = $produto->save();

        if ($salvou) {
            return redirect('/produtos')->with('mensagem', 'Produto criado com sucesso');
        } else {
            return redirect()->back()->with('mensagem', 'Erro ao criar o produto');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        if ($this->usuarioLogado->cannot('view', Produto::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        $usuarioCriacao = Usuario::find($produto->usuario_id_inclusao);
        $usuarioAlteracao = Usuario::find($produto->usuario_id_alteracao);
        
        $produto->usuario_inclusao = $usuarioCriacao->primeiro_nome.' '.$usuarioCriacao->sobrenome;
        $produto->usuario_alteracao = $usuarioAlteracao 
            ? $usuarioAlteracao->primeiro_nome.' '.$usuarioAlteracao->sobrenome
            : 'Nunca atualizado';
        
        return view('produto_show', ['produto' => $produto]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        if ($this->usuarioLogado->cannot('update', Produto::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        return view('produto_edit', ['produto' => $produto]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($this->usuarioLogado->cannot('update', Produto::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        $produto = Produto::find($id);
        
        $produto->codigo = $request->codigo;
        $produto->produto = $request->produto;
        $produto->descricao = $request->descricao;
        $produto->ativo = $request->ativo;
        $produto->em_estoque = $request->em_estoque;
        $produto->usuario_id_alteracao = $this->usuarioLogado->id;

        $atualizou = $produto->save();

        if ($atualizou) {
            return redirect('/produtos')->with('mensagem', 'Produto atualizado com sucesso');
        } else {
            return redirect()->back()->with('mensagem', 'Erro ao atualizar o produto');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {  
        if ($this->usuarioLogado->cannot('delete', Produto::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        $inativou = Produto::where('id', $produto->id)
            ->update([
                'ativo' => $produto->ativo === 1 ? 0 : 1,
                'usuario_id_alteracao' => $this->usuarioLogado->id
            ]);

        if ($inativou) {
            return redirect('/produtos')->with('mensagem', 'Produto atualizado com sucesso');
        } else {
            return redirect()->back()->with('mensagem', 'Erro ao atualizar o produto');
        }
    }
}
