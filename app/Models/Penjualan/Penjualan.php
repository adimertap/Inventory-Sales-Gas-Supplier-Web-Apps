<?php

namespace App\Models\Penjualan;

use App\Models\Master\Customer;
use App\Models\Master\Produk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    use SoftDeletes;

    protected $table = "tb_penjualan";

    protected $primaryKey = 'id_penjualan';

    protected $fillable = [
        'id',
        'customer_id',
        'kode_penjualan',
        'tanggal_penjualan',
        'status_bayar',
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
        return $this->belongsToMany(Produk::class, 'tb_detail_penjualan', 'id_penjualan', 'id_produk')->withPivot('jumlah_jual', 'harga_jual', 'total_jual');
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id_customer');
    }

    public function Pegawai()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public static function getId()
    {
        $getId = DB::table('tb_penjualan')->orderBy('id_penjualan', 'DESC')->take(1)->get();
        if (count($getId) > 0) return $getId;
        return (object)[
            (object)[
                'id_penjualan' => 0
            ]
        ];
    }
}
