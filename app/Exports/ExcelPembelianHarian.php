<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class ExcelPembelianHarian implements FromView, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($pembelian, $produk, $hari)
    {
        $this->pembelian = $pembelian;
        $this->produk = $produk;
        $this->hari = $hari;
    }

    public function view(): View
    {
        return view('pdf.pembelian.harian.excel',['pembelian' => $this->pembelian, 'produk' => $this->produk, 'hari' => $this->hari]);
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
