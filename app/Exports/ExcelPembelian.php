<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ExcelPembelian implements FromView, ShouldAutoSize, WithEvents
{
    public function __construct($pembelian, $produk)
    {
        $this->pembelian = $pembelian;
        $this->produk = $produk;
    }

    public function view(): View
    {
        return view('pdf.pembelian.seluruh.excel',['pembelian' => $this->pembelian, 'produk' => $this->produk]);
    }

    public function registerEvents(): array
    {

        return[
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A1:J1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    
                ]);

            }
        ];
    }
}
