<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Usuario;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            
            $xls = new Spreadsheet();
            $sheet = $xls->getActiveSheet();
            
            $headers = [
                'id',
                'primeiro_nome',
                'sobrenome',
                'perfil',
                'status'
            ];

            $col = 1;
            foreach ($headers as $header) {
                $sheet->setCellValue([$col, 1], $header);
                $col++;
            }

            $usuarios = Usuario::all();

            $row = 2; 
            foreach ($usuarios as $usuario) {
                $sheet->setCellValue([1, $row], $usuario->id);
                $sheet->setCellValue([2, $row], $usuario->primeiro_nome);
                $sheet->setCellValue([3, $row], $usuario->sobrenome);
                $sheet->setCellValue([4, $row], $usuario->perfil);
                $sheet->setCellValue([5, $row], $usuario->ativo === 1 ? 'Sim' : 'Não');
                $row++;
            }

            $writer = new Xlsx($xls);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode('usuarios_'.date("Y-m-d__H:i:s").'.xlsx').'"');
            $writer->save('php://output');
        }

        if ($tipo === 'produtos' && $formato === 'xlsx') {
            
            $xls = new Spreadsheet();
            $sheet = $xls->getActiveSheet();

            $headers = [
                'id',
                'codigo',
                'produto',
                'descrição',
                'em estoque',
                'ativo'
            ];

            $col = 1;
            foreach ($headers as $header) {
                $sheet->setCellValue([$col, 1], $header);
                $col++;
            }

            $produtos = Produto::all();

            $row = 2; 
            foreach ($produtos as $produto) {
                $sheet->setCellValue([1, $row], $produto->id);
                $sheet->setCellValue([2, $row], $produto->codigo);
                $sheet->setCellValue([3, $row], $produto->produto);
                $sheet->setCellValue([4, $row], $produto->descricao);
                $sheet->setCellValue([5, $row], $produto->em_estoque === 1 ? 'Sim' : 'Não');
                $sheet->setCellValue([6, $row], $produto->ativo === 1 ? 'Sim' : 'Não');
                $row++;
            }

            $writer = new Xlsx($xls);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="'. urlencode('produtos_'.date("Y-m-d__H:i:s").'.xlsx').'"');
            $writer->save('php://output');
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
