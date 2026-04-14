<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'idcust';
    public $timestamps = true;

    protected $fillable = [
        'nama',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kodepos',
        'foto',
        'foto_path',
    ];
}
