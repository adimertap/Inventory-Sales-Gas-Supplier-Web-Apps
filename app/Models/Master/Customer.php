<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    use SoftDeletes;

    protected $table = "tb_master_customer";

    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'nama_customer',
        'kode_customer',
        'no_hp_customer',
        'email_customer',
        'kota_customer',
        'alamat_customer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;

    public static function getId()
    {
        $getId = DB::table('tb_master_customer')->orderBy('id_customer', 'DESC')->take(1)->get();
        if (count($getId) > 0) return $getId;
        return (object)[
            (object)[
                'id_customer' => 0
            ]
        ];
    }
}
