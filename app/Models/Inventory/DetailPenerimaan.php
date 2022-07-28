<?php

namespace App\Models\Inventory;

use App\Models\Master\Produk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenerimaan extends Model
{
    protected $table = "tb_detail_penerimaan";

    protected $primaryKey = 'id_detail_penerimaan';

    protected $fillable = [
        'id_penerimaan',
        'id_produk',
        'jumlah_order',
        'jumlah_diterima',
        'harga_diterima',
        'total_diterima',
        'kode_pembelian'
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
