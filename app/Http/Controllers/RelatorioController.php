<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Usuario;
use Dompdf\Dompdf;
use Spreadsheet_Excel_Writer;
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

    public function show(string $tipo, string $formato)
    {
        if ($tipo === 'usuarios' && $formato === 'pdf') {
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

        if ($tipo === 'produtos' && $formato === 'pdf') {
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

        if ($tipo === 'usuarios' && $formato === 'xlsx') {
            
            $xls = new Spreadsheet_Excel_Writer();
            $xls->setVersion(8); //versão mais atual
            
            $xls->send('usuarios_'.date("Y-m-d__H:i:s").'.xls');

            $sheet = $xls->addWorksheet('Planilha1');
            $sheet->setInputEncoding('UTF-8');

            $headers = [
                'id',
                'primeiro_nome',
                'sobrenome',
                'perfil',
                'status'
            ];

            $row = $col = 0;
            foreach ($headers as $header) {
                $sheet->write($row, $col, $header);
                $col++;
            }

            $usuarios = Usuario::all();

            $row = 0;
            foreach ($usuarios as $usuario) {
                $data = [
                    'id' => $usuario->id,
                    'primeiro_nome' => $usuario->primeiro_nome,
                    'sobrenome' => $usuario->sobrenome,
                    'perfil' => $usuario->perfil,
                    'status' => $usuario->ativo === 1 ? 'Sim' : 'Não'
                ];

                $sheet->writeRow($row, 0, $data);
                $row++;
            }

            $xls->close();
        }

        if ($tipo === 'produtos' && $formato === 'xlsx') {
            
            $xls = new Spreadsheet_Excel_Writer();
            $xls->setVersion(8); //versão mais atual
            
            $xls->send('produtos_'.date("Y-m-d__H:i:s").'.xls');

            $sheet = $xls->addWorksheet('Planilha1');
            $sheet->setInputEncoding('UTF-8');

            $headers = [
                'id',
                'codigo',
                'produto',
                'descrição',
                'em estoque',
                'ativo'
            ];

            $row = $col = 0;
            foreach ($headers as $header) {
                $sheet->write($row, $col, $header);
                $col++;
            }

            $produtos = Produto::all();

            $row = 0;
            foreach ($produtos as $produto) {
                $data = [
                    'id' => $produto->id,
                    'codigo' => $produto->codigo,
                    'produto' => $produto->produto,
                    'descrição' => $produto->descricao,
                    'em estoque' => $produto->em_estoque === 1 ? 'Sim' : 'Não',
                    'ativo' => $produto->ativo === 1 ? 'Sim' : 'Não',
                ];

                $sheet->writeRow($row, 0, $data);
                $row++;
            }

            $xls->close();
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
