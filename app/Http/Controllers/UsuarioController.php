<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public readonly Usuario $usuario;
    public readonly Usuario $usuarioLogado;

    public function __construct() {
        $this->usuario = new Usuario();
        $this->usuarioLogado = Auth::user();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        if ($this->usuarioLogado->cannot('view', Usuario::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        $usuarios = $this->usuario->all();
        return view('usuario_index', ['usuarios' => $usuarios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if ($this->usuarioLogado->cannot('create', Usuario::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        return view('usuario_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->usuarioLogado->cannot('create', Usuario::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        $usuario = $this->usuario;
        $usuario->primeiro_nome = $request->primeiro_nome;
        $usuario->sobrenome = $request->sobrenome;
        $usuario->email = $request->email;
        $usuario->senha = password_hash($request->senha, PASSWORD_BCRYPT);

        $salvou = $usuario->save();

        if ($salvou) {
            return redirect('/usuarios')->with('mensagem', 'Usuário criado com sucesso');
        } else {
            return redirect()->back()->with('mensagem', 'Erro ao criar o usuário');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuario $usuario)
    {
        if ($this->usuarioLogado->cannot('view', Usuario::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        return view('usuario_show', ['usuario' => $usuario]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Usuario $usuario)
    {
        if ($this->usuarioLogado->cannot('update', Usuario::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        return view('usuario_edit', ['usuario' => $usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($this->usuarioLogado->cannot('update', Usuario::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        $usuario = $this->usuario->find($id);
        
        $usuario->primeiro_nome = $request->primeiro_nome;
        $usuario->sobrenome = $request->sobrenome;
        $usuario->email = $request->email;
        $usuario->ativo = $request->ativo;

        $atualizou = $usuario->save();

        if ($atualizou) {
            return redirect('/usuarios')->with('mensagem', 'Usuário atualizado com sucesso');
        } else {
            return redirect()->back()->with('mensagem', 'Erro ao atualizar o usuário');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->usuarioLogado->cannot('delete', Usuario::class)) {
            abort(403, 'Você não tem as permissões necessárias.');
        }

        $excluiu = $this->usuario->destroy($id);

        if ($excluiu) {
            return redirect('/usuarios')->with('mensagem', 'Usuário excluido com sucesso');
        } else {
            return redirect()->back()->with('mensagem', 'Erro ao excluir o usuário');
        }
    }
}
