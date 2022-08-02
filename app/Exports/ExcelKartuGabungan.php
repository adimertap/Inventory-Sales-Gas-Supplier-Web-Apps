<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelKartuGabungan implements FromCollection, Responsable, ShouldAutoSize,
WithMapping, WithHeadings, WithColumnWidths, WithEvents, WithCustomStartCell
{
    use Exportable;
    public $kartu;
    private $fileName = "report-produk.xlsx";


    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($kartu)
    {
        $this->kartu = $kartu;
      
    }

    public function collection()
    {
        return $this->kartu;
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
            'Kode Transaksi',
            'Tanggal Transaksi',
            'Jenis Transaksi',
            'Nama Produk',
            'Kategori',
            'Jumlah Masuk',
            'Jumlah Keluar',
            'Harga Beli',
            'Harga Jual'
        ];
    }

    public function map($kartu): array
    {
            return[
                $kartu->kode_transaksi,
                $kartu->tanggal_transaksi,
                $kartu->jenis_kartu,
                $kartu->nama_produk,
                $kartu->nama_kategori,
                $kartu->jumlah_masuk?? "-",
                $kartu->jumlah_keluar?? "-",
                $kartu->harga_beli?? "-",
                $kartu->harga_jual?? "-",
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
