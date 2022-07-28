<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Supplier extends Model
{
    use SoftDeletes;

    protected $table = "tb_master_supplier";

    protected $primaryKey = 'id_supplier';

    protected $fillable = [
        'nama_supplier',
        'email_supplier',
        'no_hp_supplier',
        'kota_supplier',
        'alamat_supplier',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;
}
