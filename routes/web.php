<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', [HomeController::class, 'index'])->name('home.index');

Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::delete('/login/sair', [LoginController::class, 'destroy'])->name('login.destroy');

Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuario.index');
Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('usuario.create');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuario.store');
Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuario.show');
Route::get('/usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuario.edit');
Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuario.update');
Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuario.destroy');

Route::get('/produtos', [ProdutoController::class, 'index'])->name('produto.index');
Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produto.create');
Route::post('/produtos', [ProdutoController::class, 'store'])->name('produto.store');
Route::get('/produtos/{produto}', [ProdutoController::class, 'show'])->name('produto.show');
Route::get('/produtos/{produto}/edit', [ProdutoController::class, 'edit'])->name('produto.edit');
Route::put('/produtos/{produto}', [ProdutoController::class, 'update'])->name('produto.update');
Route::post('/produtos/{produto}', [ProdutoController::class, 'destroy'])->name('produto.destroy');

Route::get('/relatorios/{relatorio}/{formato}', [RelatorioController::class, 'show'])->name('relatorio.show');