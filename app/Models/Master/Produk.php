<?php

namespace App\Models\Master;

use App\Models\Inventory\KartuGudang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;

    protected $table = "tb_master_produk";

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'jumlah_minimal',
        'status_jumlah',
        'stok'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;

    public function Kategori()
    {
        return $this->belongsTo(Category::class, 'kategori_id', 'id_kategori')->withTrashed();
    }

    public function Kartupenerimaan()
    {
        return $this->hasOne(KartuGudang::class, 'id_produk', 'id_produk')->where('jenis_kartu', 'Penerimaan')->orderBy('updated_at', 'DESC');
    }

    public function Kartugudangsaldoakhir()
    {
        return $this->hasOne(Kartugudang::class, 'id_produk', 'id_produk')->orderBy('updated_at', 'DESC');;
    }

    public function Kartugudangterakhir()
    {
        return $this->hasOne(KartuGudang::class, 'id_produk', 'id_produk')->where('jenis_kartu', 'Penjualan')->orderBy('updated_at', 'DESC');
    }

}
