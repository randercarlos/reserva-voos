<?php

namespace App\Reports;

use App\Interfaces\ReportInterface;
use App\Traits\ReportTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class BrandReport extends Fpdf implements ReportInterface
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
}
