<?php

namespace App\Traits;

use Codedge\Fpdf\Fpdf\Fpdf;

trait ReportTrait
{
    public function texto($str)
    {
        return iconv('UTF-8', 'windows-1252', $str);
    }

    // Page footer
    public function Footer()
    {
        // Posiciona a 1.5cm do rodapé
        $this->SetY(-15);

        // Seta a fonte e a cor
        $this->SetFont(self::FONT, 'I', self::FONT_RODAPE_W);
        $this->SetTextColor(0);

        // Define o número de página
        $this->Cell(0, 5, $this->texto('Página '.$this->PageNo().'/{nb}'), 'T', 0, 'C');
    }

    // Page footer
    public function Header()
    {
        // Logo
        //$this->Image('logo.png', 0, 0);
        $this->SetY(15);
        $this->SetTextColor(75, 0, 130);
        $this->SetFont(self::FONT, '', 12);

        // Header
        $this->Image(public_path().'/assets/site/images/report_logo.png', 20, 4, 50, 30);

        $this->Cell(0, 5, $this->texto(env('APP_NAME').' - '.env('APP_COMPANY')), '', 0, 'R');

        // Line break
        $this->Ln(15);
    }

    public function gerarTabela($data)
    {
        // configurações de fonte, tamanho de fonte e cores do cabeçalho da tabela
        $this->configHeaderTable();

        // Defini cada coluna do cabeçalho da tabela(Tamanho total da linha é 277)
        $this->Cell(20, self::CELL_TABLE_H, $this->texto('Id'), 'BT', 0, 'C', true);
        $this->Cell(145, self::CELL_TABLE_H, $this->texto('Nome'), 'BT', 0, 'L', true);
        $this->Cell(55, self::CELL_TABLE_H, $this->texto('Criado em'), 'BT', 0, 'C', true);
        $this->Cell(55, self::CELL_TABLE_H, $this->texto('Última alteração'), 'BT', 0, 'C', true);

        // configurações de fonte, tamanho de fonte e cores do corpo da tabela
        $this->configBodyTable();

        // Data
        $colorir_linha = false;
        foreach ($data as $row) {
            // Defini cada coluna do corpo da tabela(Tamanho total da linha é 277)
            $this->Cell(20, self::CELL_TABLE_H, $this->texto($row['id']), '', 0, 'C', $colorir_linha);
            $this->Cell(145, self::CELL_TABLE_H, $this->texto($row['name']), '', 0, 'L', $colorir_linha);
            $this->Cell(55, self::CELL_TABLE_H, $row['created_at'], '', 0, 'C', $colorir_linha);
            $this->Cell(55, self::CELL_TABLE_H, $row['updated_at'], '', 0, 'C', $colorir_linha);

            $this->Ln();
            $colorir_linha = ! $colorir_linha;
        }

        // fecha a linha
        $this->Cell(0, 0, '', 'T', 1);
    }

    protected function configHeaderTable()
    {
        // Seta o preenchimento do cabeçalho da tabela para branco
        $this->SetFillColor(255, 255, 255);

        // Seta a cor do cabeçalho da tabela
        $this->SetTextColor(0, 0, 153);

        // Seta a cor das bordas do cabeçalho da tabela
        $this->SetDrawColor(84, 84, 83);

        // seta a largura das bordas do cabeçalho da tabela
        $this->SetLineWidth(0.4);

        // seta a fonte da tabela
        $this->SetFont(self::FONT, 'B', self::FONT_NORMAL_W);
    }

    protected function configBodyTable()
    {
        $this->Ln();

        // Restora as cores e fontes para o corpo da tabela
        $this->SetFillColor(230, 230, 230);
        $this->SetTextColor(0);
        $this->SetFont(self::FONT, '', self::FONT_NORMAL_W);
    }

    public function generateReport(Fpdf $pdf, $titleReport, $data)
    {
        $pdf->AliasNbPages();

        $pdf->AddPage();

        // Define a fonte, cor e imprimi o título do relatório
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->SetTextColor(0, 0, 153);
        $pdf->Cell(0, 10, $pdf->texto($titleReport), 0, 1, 'C');

        $pdf->gerarTabela($data);

        // Define a fonte, cor e imprimi o total de registros
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 153);
        $pdf->Cell(0, 15, $pdf->texto('Relatório gerado em: '.date('d/m/Y H:i:s')), 0, 0, 'L');
        $pdf->Cell(0, 15, $pdf->texto('Total de Registros: '.count($data)), 0, 0, 'R');
        $pdf->Output();
        //exit;
    }
}
