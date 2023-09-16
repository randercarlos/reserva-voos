<?php

namespace App\Reports;

use App\Interfaces\ReportInterface;
use App\Models\Reserve;
use App\Traits\ReportTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class ReserveReport extends Fpdf implements ReportInterface
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
        $this->Cell(80, self::CELL_TABLE_H, $this->texto('Usuário'), 'BT', 0, 'L', true);
        $this->Cell(80, self::CELL_TABLE_H, $this->texto('Voo'), 'BT', 0, 'C', true);
        $this->Cell(70, self::CELL_TABLE_H, $this->texto('Data Reserva'), 'BT', 0, 'C', true);
        $this->Cell(30, self::CELL_TABLE_H, $this->texto('Status'), 'BT', 0, 'C', true);

        // configurações de fonte, tamanho de fonte e cores do corpo da tabela
        $this->configBodyTable();

        // Data
        $colorir_linha = false;
        foreach ($data as $row) {
            $reserva = new Reserve();
            // Defini cada coluna do corpo da tabela(Tamanho total da linha é 277)
            $this->Cell(17, self::CELL_TABLE_H, $row['id'], '', 0, 'C', $colorir_linha);
            $this->Cell(80, self::CELL_TABLE_H, $this->texto($row['user']['name']), '', 0, 'L', $colorir_linha);
            $this->Cell(80, self::CELL_TABLE_H, $row['flight']['id'], '', 0, 'C', $colorir_linha);
            $this->Cell(70, self::CELL_TABLE_H, \DateTime::createFromFormat('Y-m-d', $row['date_reserved'])
                ->format('d/m/Y'), '', 0, 'C', $colorir_linha);
            $this->Cell(30, self::CELL_TABLE_H, $reserva->getStatus($row['status']), '', 0, 'C', $colorir_linha);

            $this->Ln();
            $colorir_linha = ! $colorir_linha;
        }

        // fecha a linha
        $this->Cell(0, 0, '', 'T', 1);
    }
}
