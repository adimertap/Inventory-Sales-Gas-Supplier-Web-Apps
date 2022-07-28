<?php

namespace App\Models\Inventory;

use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelian extends Model
{
    protected $table = "tb_detail_pembelian";

    protected $primaryKey = 'id_detail_pembelian';

    protected $fillable = [
        'id_pembelian',
        'id_produk',
        'jumlah_order',
        'harga_beli',
        'total_order',
        'qty_sementara'
    ];

    protected $hidden =[ 
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function Pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian','id_pembelian');
    }

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk','id_produk');
    }

}
