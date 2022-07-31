<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisSupplier extends Model
{
    use SoftDeletes;

    protected $table = "tb_master_jenis_supplier";

    protected $primaryKey = 'id_jenis_supplier';

    protected $fillable = [
        'nama_jenis',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;
}
