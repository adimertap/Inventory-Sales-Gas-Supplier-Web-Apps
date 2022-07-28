<?php

namespace App\Models\Inventory;

use App\Models\Master\Customer;
use App\Models\Master\Produk;
use App\Models\Master\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KartuGudang extends Model
{
    use SoftDeletes;

    protected $table = "tb_kartu_gudang";

    protected $primaryKey = 'id_kartu_gudang';

    protected $fillable = [
        'id_produk',
        'id_supplier',
        'id_customer',
        'kode_transaksi',
        'tanggal_transaksi',
        'saldo_awal',
        'jumlah_masuk',
        'jumlah_keluar',
        'saldo_akhir',
        'jenis_kartu',
        'harga_beli',
        'harga_jual'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }
}
