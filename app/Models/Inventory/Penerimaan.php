<?php

namespace App\Models\Inventory;

use App\Models\Master\Produk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Penerimaan extends Model
{
    use SoftDeletes;

    protected $table = "tb_penerimaan";

    protected $primaryKey = 'id_penerimaan';

    protected $fillable = [
        'id',
        'id_pembelian',
        'kode_penerimaan',
        'tanggal_penerimaan',
        'status_pembayaran',
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
        return $this->belongsToMany(Produk::class, 'tb_detail_penerimaan', 'id_penerimaan', 'id_produk')->withPivot('kode_Pembelian','jumlah_order', 'jumlah_diterima', 'harga_diterima','total_diterima');
    }

    public function Pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'id_pembelian', 'id_pembelian')->withTrashed();
    }

    public function Pegawai()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public static function getId()
    {
        $getId = DB::table('tb_penerimaan')->orderBy('id_penerimaan', 'DESC')->take(1)->get();
        if (count($getId) > 0) return $getId;
        return (object)[
            (object)[
                'id_penerimaan' => 0
            ]
        ];
    }
}
