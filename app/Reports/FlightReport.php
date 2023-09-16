<?php

namespace App\Reports;

use App\Interfaces\ReportInterface;
use App\Traits\ReportTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class FlightReport extends Fpdf implements ReportInterface
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
        $this->Cell(50, self::CELL_TABLE_H, $this->texto('Avião'), 'BT', 0, 'L', true);
        $this->Cell(80, self::CELL_TABLE_H, $this->texto('Origem'), 'BT', 0, 'L', true);
        $this->Cell(70, self::CELL_TABLE_H, $this->texto('Destino'), 'BT', 0, 'L', true);
        $this->Cell(30, self::CELL_TABLE_H, $this->texto('Data'), 'BT', 0, 'C', true);
        $this->Cell(30, self::CELL_TABLE_H, $this->texto('Saída'), 'BT', 0, 'C', true);

        // configurações de fonte, tamanho de fonte e cores do corpo da tabela
        $this->configBodyTable();

        // Data
        $colorir_linha = false;
        foreach ($data as $row) {
            // Defini cada coluna do corpo da tabela(Tamanho total da linha é 277)
            $this->Cell(17, self::CELL_TABLE_H, '#'.$row['id'], '', 0, 'C', $colorir_linha);
            $this->Cell(50, self::CELL_TABLE_H, $this->texto($row['airplane']['name']), '', 0, 'L', $colorir_linha);
            $this->Cell(80, self::CELL_TABLE_H, $this->texto($row['origin']['name']), '', 0, 'L', $colorir_linha);
            $this->Cell(70, self::CELL_TABLE_H, $this->texto($row['destination']['name']), '', 0, 'L', $colorir_linha);
            $this->Cell(30, self::CELL_TABLE_H, \DateTime::createFromFormat('Y-m-d', $row['date'])->format('d/m/Y'),
                '', 0, 'C', $colorir_linha);
            $this->Cell(30, self::CELL_TABLE_H, $row['hour_output'], '', 0, 'C', $colorir_linha);

            $this->Ln();
            $colorir_linha = ! $colorir_linha;
        }

        // fecha a linha
        $this->Cell(0, 0, '', 'T', 1);
    }
}
