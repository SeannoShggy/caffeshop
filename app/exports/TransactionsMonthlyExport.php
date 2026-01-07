<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Events\AfterSheet;

class TransactionsMonthlyExport implements FromArray, WithStyles, WithColumnWidths, WithEvents
{
    protected $month;
    protected $rows = [];
    protected $mergeMap = [];

    public function __construct($month)
    {
        $this->month = $month;
    }

    public function array(): array
    {
        [$year, $month] = explode('-', $this->month);

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end   = Carbon::create($year, $month, 1)->endOfMonth();

        $orders = Transaction::with('product')
            ->whereBetween('transaction_date', [$start, $end])
            ->orderBy('transaction_date')
            ->get()
            ->groupBy('order_id');

        // HEADER (TANPA TOTAL)
        $this->rows[] = [
            'No', 'Tanggal', 'Nama', 'Produk', 'Harga', 'Catatan'
        ];

        $rowIndex = 2;
        $no = 1;

        foreach ($orders as $order) {
            $startRow = $rowIndex;

            foreach ($order as $trx) {
                $this->rows[] = [
                    $no,
                    $trx->transaction_date->format('d M Y'),
                    $trx->customer_name,
                    $trx->product->name . ' (' . $trx->quantity . ')',
                    'Rp ' . number_format($trx->price, 0, ',', '.'),
                    $trx->note ?? '-',
                ];

                $rowIndex++;
            }

            $endRow = $rowIndex - 1;

            if ($endRow > $startRow) {
                $this->mergeMap[] = [$startRow, $endRow];
            }

            $no++;
        }

        return $this->rows;
    }

    /**
     * MERGE CELL PER ORDER
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach ($this->mergeMap as [$start, $end]) {
                    $event->sheet->mergeCells("A{$start}:A{$end}");
                    $event->sheet->mergeCells("B{$start}:B{$end}");
                    $event->sheet->mergeCells("C{$start}:C{$end}");
                    $event->sheet->mergeCells("F{$start}:F{$end}");
                }
            },
        ];
    }

    /**
     * STYLE
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 16,
            'C' => 14,
            'D' => 30,
            'E' => 14,
            'F' => 20,
        ];
    }
}
