<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\OrderItem;
use TCPDF;


class ReportController extends Controller
{
    //
    public function Index(){
        
        $products = Product::where('is_active', true)->count();//quantidade de produtos cadastrados no banco
        $stock = DB::table('stock_mutations')->count();//quantidade de registros de alteração de estoque
        $order = DB::table('order_item')->count();
        $user = DB::table('users')->count();//quantidade de registro de usuários no sistema
        //DATASET QUANTIDADE(Y) X PRODUTO(X)
        $prodName = DB::table('products')->where('is_active', true)->orderBy('created_at')->pluck('nome')->toArray(); //coluna de nome dos produtos ordenados por inserção
        $qtdStockP = DB::table('stocks')->orderBy('created_at')->pluck('quantidade')->toArray(); //coluna de quantidade em estoque ordenado por inserção
        return view('admin.report', compact('products', 'stock', 'user', 'prodName', 'qtdStockP', 'order'));
    }

    public function GerarPDF(Request $request)
    {
        $prodNome = $request->input('prodNome');
        $qtdStockP = $request->input('qtdStockP');

        // Gera a URL do gráfico com os dados recebidos
        $chartUrl = $this->generateChartUrl($prodNome, $qtdStockP);

        // Baixa e salva a imagem do gráfico
        $imagePath = $this->downloadChartImage($chartUrl);

        if (!$imagePath) {
            return response()->json(['status' => 'error', 'message' => 'Failed to download chart image.']);
        }

        // Gera o PDF com a imagem do gráfico, texto e tabela
        $pdfFilePath = $this->createPdf($prodNome, $qtdStockP, $imagePath);

        // Exclui a imagem temporária
        unlink($imagePath);

        // Prepara o download do PDF
        return response()->download($pdfFilePath)->deleteFileAfterSend(true);
    }

    private function generateChartUrl($labels, $data){
        $chartConfig = json_encode([
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Quantidade em estoque!',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ]]
            ],
            'options' => [
                'scales' => [
                    'y' => [
                        'beginAtZero' => true
                    ]
                ]
            ]
        ]);

        return 'https://quickchart.io/chart?c=' . urlencode($chartConfig);
    }

    private function downloadChartImage($url){
        // Baixa a imagem do gráfico
        $imageContent = file_get_contents($url);
        if ($imageContent === false) {
            return false;
        }

        $imagePath = public_path('chart.png');
        file_put_contents($imagePath, $imageContent);

        // Verifica se a imagem foi salva corretamente
        if (!file_exists($imagePath)) {
            return false;
        }

        return $imagePath;
    }


    private function createPdf($prodNome, $qtdStockP, $imagePath){
        // Inicializa TCPDF
        $pdf = new TCPDF();
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();

        // Adiciona o título ao PDF
        $pdf->SetFont('helvetica', 'B', 20);
        $pdf->Cell(0, 10, 'Relatório de Produtos', 0, 1, 'C');

        // Adiciona texto antes da imagem
        $pdf->SetFont('helvetica', '', 12);
        $pdf->MultiCell(0, 10, 'Este relatório mostra a quantidade em estoque dos produtos.', 0, 'L', 0, 1, '', '', true);

        // Adiciona a imagem do gráfico ao PDF
        $pdf->Image($imagePath, 15, 40, 180, 100, 'PNG');

        // Adiciona a tabela ao PDF
        $pdf->SetY(150); // Define a posição Y após a imagem
        $pdf->writeHTML($this->generateTableHtml($prodNome, $qtdStockP), true, false, true, false, '');

        // Salva o PDF em um arquivo temporário
        $pdfFilePath = storage_path('app/public/charts.pdf');
        $pdf->Output($pdfFilePath, 'F');

        return $pdfFilePath;
    }

    private function generateTableHtml($prodNome, $qtdStockP)
    {
        $tableHtml = '<table border="1" cellpadding="4">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade em Estoque</th>
                </tr>
            </thead>
            <tbody>';

        foreach ($prodNome as $index => $label) {
            $tableHtml .= '<tr>
                    <td>' . $label . '</td>
                    <td>' . $qtdStockP[$index] . '</td>
                </tr>';
        }

        $tableHtml .= '</tbody></table>';

        return $tableHtml;
    }
}
    



