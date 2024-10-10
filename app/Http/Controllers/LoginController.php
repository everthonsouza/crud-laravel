<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|min:6'
        ], [
            'email.required' => 'O campo de e-mail é obrigatório',
            'email.email' => 'O e-mail deve ser válido',
            'senha.required' => 'O campo de senha é obrigatório',
            'senha.min' => 'A senha deve ter no mínimo :min caracteres',
        ]);

        $usuario = Usuario::where('email', $request->email)->first();

        if ($usuario != null && $usuario->ativo === 0) {
            return redirect()->route('login.index')->withErrors(['error' => 'Usuário desativado, entre em contato com o administrador do sistema']);
        }

        if ($usuario != null && password_verify($request->senha, $usuario->senha)) {
            Auth::login($usuario);
            return redirect()->route("home.index");
        }

        return redirect()->route('login.index')->withErrors(['error' => 'E-mail ou senha incorretos']);
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route("login.index");
    }
}
