<?php

namespace App\Models\Penjualan;

use App\Models\Inventory\KartuGudang;
use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table = "tb_detail_penjualan";

    protected $primaryKey = 'id_detail_penjualan';

    protected $fillable = [
        'id_penjualan',
        'id_produk',
        'jumlah_jual',
        'harga_jual',
        'total_jual',
    ];

    protected $hidden =[ 
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;

    public function Penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_penjualan','id_penjualan');
    }

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk','id_produk');
    }
}