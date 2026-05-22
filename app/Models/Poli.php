<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    protected $table = 'poli';
    protected $primaryKey = 'idpoli';
    protected $fillable = ['nama_poli'];

    public function antrean()
    {
        return $this->hasMany(Antrean::class, 'idpoli', 'idpoli');
    }
}
