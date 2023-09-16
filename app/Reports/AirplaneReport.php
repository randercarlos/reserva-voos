<?php

namespace App\Reports;

use App\Interfaces\ReportInterface;
use App\Models\Airplane;
use App\Traits\ReportTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class AirplaneReport extends Fpdf implements ReportInterface
{
    use ReportTrait;

    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4')
    {
        parent::__construct($orientation, $unit, $size);
    }

    public function gerarTabela($data)
    {
        // configurações de fonte, tamanho de fonte e cores do cabeçalho da tabela
        $this->configHeaderTable();

        // Defini cada coluna do cabeçalho da tabela(Tamanho total da linha é 277)
        $this->Cell(27, self::CELL_TABLE_H, $this->texto('Id'), 'BT', 0, 'C', true);
        $this->Cell(80, self::CELL_TABLE_H, $this->texto('Nome'), 'BT', 0, 'L', true);
        $this->Cell(70, self::CELL_TABLE_H, $this->texto('Marca'), 'BT', 0, 'L', true);
        $this->Cell(50, self::CELL_TABLE_H, $this->texto('Qtd. de Passeiros'), 'BT', 0, 'C', true);
        $this->Cell(50, self::CELL_TABLE_H, $this->texto('Classe'), 'BT', 0, 'C', true);

        // configurações de fonte, tamanho de fonte e cores do corpo da tabela
        $this->configBodyTable();

        // Data
        $colorir_linha = false;
        foreach ($data as $row) {
            // Defini cada coluna do corpo da tabela(Tamanho total da linha é 277)
            $this->Cell(27, self::CELL_TABLE_H, $this->texto($row['id']), '', 0, 'C', $colorir_linha);
            $this->Cell(80, self::CELL_TABLE_H, $this->texto($row['name']), '', 0, 'L', $colorir_linha);
            $this->Cell(70, self::CELL_TABLE_H, $row['brand']['name'], '', 0, 'L', $colorir_linha);
            $this->Cell(50, self::CELL_TABLE_H, $row['qty_passengers'], '', 0, 'C', $colorir_linha);
            $this->Cell(50, self::CELL_TABLE_H, $this->texto(Airplane::getClass($row['class'])), '', 0, 'C',
                $colorir_linha);

            $this->Ln();
            $colorir_linha = ! $colorir_linha;
        }

        // fecha a linha
        $this->Cell(0, 0, '', 'T', 1);
    }
}
