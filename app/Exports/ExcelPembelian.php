<?php

namespace App\Exports;

use App\Models\Inventory\Pembelian as InventoryPembelian;
use App\Models\Master\JenisSupplier;
use App\Models\Pembelian;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelPembelian implements FromCollection, Responsable, ShouldAutoSize,
WithMapping, WithHeadings, WithColumnWidths, WithEvents, WithCustomStartCell
{
    use Exportable;
    public $pembelian;
    public $grand_total;
    private $fileName = "report.xlsx";

    public function __construct($pembelian)
    {
        $this->pembelian = $pembelian;
        $this->grand_total = $pembelian->sum('grand_total');
        $this->total_produk = $pembelian->count('id_produk');
    }

   

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->pembelian;
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
            'Kode Pembelian',
            'Tanggal Pembelian',
            'Supplier',
            'Jenis Supplier',
            'Nama Produk',
            'Kategori',
            'Jumlah Order',
            'Harga Order',
            'Total Order'
        ];
    }

    public function map($pembelian): array
    {
            return[
                $pembelian->kode_pembelian,
                $pembelian->tanggal_pembelian,
                $pembelian->nama_supplier,
                $pembelian->nama_jenis,
                $pembelian->nama_produk,
                $pembelian->nama_kategori,
                $pembelian->jumlah_order,
                $pembelian->harga_beli,
                $pembelian->total_order
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
