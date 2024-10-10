<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Usuario;
use Dompdf\Dompdf;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public readonly \Mpdf\Mpdf $mpdf;
    public readonly Dompdf $dompdf;

    public function __construct() {
        require_once dirname(__DIR__, 3) . '/vendor/autoload.php';
        $this->mpdf = new \Mpdf\Mpdf();
        $this->dompdf = new Dompdf();
    }

    public function show(string $tipo)
    {
        if ($tipo === 'usuarios') {
            $usuarios = Usuario::all();
    
            $html = "<h1>Lista de usuários cadastrados</h1><br><ul>"; 
            
            foreach ($usuarios as $usuario) {
                $html = $html . "<li>" . $usuario->primeiro_nome . " " . $usuario->sobrenome . "</li>";
            } 

            $html = $html . "</ul>";

            $html = $this->montarHtml($html);

            $this->mpdf->WriteHTML($html);
            $this->mpdf->Output('usuarios.pdf', \Mpdf\Output\Destination::DOWNLOAD);
        }

        if ($tipo === 'produtos') {
            $produtos = Produto::all();

            $html = "<h1>Lista de produtos cadastrados</h1><br><ul>"; 
            
            foreach ($produtos as $produto) {
                $html = $html . "<li> Cod. " . $produto->codigo . " | Produto: " . $produto->produto . "</li>";
            } 

            $html = $html . "</ul>";

            $html = $this->montarHtml($html);

            $this->dompdf->loadHtml($html);
            $this->dompdf->setPaper('A4');
            $this->dompdf->render();
            $this->dompdf->stream('produtos.pdf');
        }
    }

    public static function montarHtml(string $conteudo) : string
    {
       $html = '<!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Sistema de Cadastro</title>
        </head>
        <body>
            <h2>Relatório</h2>
            @corpo@
        </body>
        </html>';

        $html = str_replace('@corpo@', $conteudo, $html);

        return $html;
    }
}
