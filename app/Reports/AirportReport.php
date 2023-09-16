<?php

namespace App\Reports;

use App\Interfaces\ReportInterface;
use App\Traits\ReportTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class AirportReport extends Fpdf implements ReportInterface
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
        $this->Cell(17, self::CELL_TABLE_H, $this->texto('Id'), 'BT', 0, 'C', true);
        $this->Cell(125, self::CELL_TABLE_H, $this->texto('Nome'), 'BT', 0, 'L', true);
        $this->Cell(70, self::CELL_TABLE_H, $this->texto('Cidade'), 'BT', 0, 'L', true);
        $this->Cell(25, self::CELL_TABLE_H, $this->texto('Cód. Postal'), 'BT', 0, 'L', true);
        $this->Cell(20, self::CELL_TABLE_H, $this->texto('Latitude'), 'BT', 0, 'C', true);
        $this->Cell(20, self::CELL_TABLE_H, $this->texto('Logintude'), 'BT', 0, 'C', true);

        // configurações de fonte, tamanho de fonte e cores do corpo da tabela
        $this->configBodyTable();

        // Data
        $colorir_linha = false;
        foreach ($data as $row) {
            // Defini cada coluna do corpo da tabela(Tamanho total da linha é 277)
            $this->Cell(17, self::CELL_TABLE_H, $row['id'], '', 0, 'C', $colorir_linha);
            $this->Cell(125, self::CELL_TABLE_H, $this->texto($row['name']), '', 0, 'L', $colorir_linha);
            $this->Cell(70, self::CELL_TABLE_H, $this->texto($row['city']['name']).' - '.
                $this->texto($row['city']['state']['initials']), '', 0, 'L', $colorir_linha);
            $this->Cell(25, self::CELL_TABLE_H, $row['zip_code'], '', 0, 'L', $colorir_linha);
            $this->Cell(20, self::CELL_TABLE_H, $row['latitude'], '', 0, 'C', $colorir_linha);
            $this->Cell(20, self::CELL_TABLE_H, $row['longitude'], '', 0, 'C', $colorir_linha);

            $this->Ln();
            $colorir_linha = ! $colorir_linha;
        }

        // fecha a linha
        $this->Cell(0, 0, '', 'T', 1);
    }
}
