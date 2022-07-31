<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelPenjualan implements FromCollection, Responsable, ShouldAutoSize,
WithMapping, WithHeadings, WithColumnWidths, WithEvents, WithCustomStartCell
{
    use Exportable;
    public $penjualan;
    public $grand_total;
    private $fileName = "report-penjualan.xlsx";
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($penjualan)
    {
        $this->penjualan = $penjualan;
        $this->grand_total = $penjualan->sum('grand_total');
        $this->total_produk = $penjualan->count('id_produk');
    }

    public function collection()
    {
        return $this->penjualan;
    }

    public function columnWidths(): array
    {
        return [
            'C' => 30,
            'E' => 30,  
            'I' => 25,          
        ];
    }

    public function headings():array
    {
        return[
            'Kode Penjualan',
            'Tanggal Penjualan',
            'Customer',
            'Kode Customer',
            'Nama Produk',
            'Kategori',
            'Jumlah Jual',
            'Harga Jual',
            'Total Jual'
        ];
    }

    public function map($penjualan): array
    {
            return[
                $penjualan->kode_penjualan,
                $penjualan->tanggal_penjualan,
                $penjualan->nama_customer,
                $penjualan->code,
                $penjualan->nama_produk,
                $penjualan->nama_kategori,
                $penjualan->jumlah_jual,
                $penjualan->harga_jual,
                $penjualan->total_jual
            ];
            
    }

    public function registerEvents(): array
    {
        return[
            AfterSheet::class => function(AfterSheet $event){
                $event->sheet->getStyle('A3:I3')->applyFromArray([
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

    public function startCell(): string
    {
        return 'A3';
    }
}
