<?php

namespace App\Models\Inventory;

use App\Models\Master\Produk;
use App\Models\Master\Supplier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Pembelian extends Model
{
    use SoftDeletes;

    protected $table = "tb_pembelian";

    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'id',
        'id_supplier',
        'kode_pembelian',
        'tanggal_pembelian',
        'status',
        'grand_total'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;

    public function Detail()
    {
        return $this->belongsToMany(Produk::class, 'tb_detail_pembelian', 'id_pembelian', 'id_produk')->withPivot('jumlah_order', 'harga_beli', 'total_order','qty_sementara');
    }

    public function Supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function Pegawai()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public static function getId()
    {
        $getId = DB::table('tb_pembelian')->orderBy('id_pembelian', 'DESC')->take(1)->get();
        if (count($getId) > 0) return $getId;
        return (object)[
            (object)[
                'id_pembelian' => 0
            ]
        ];
    }
}