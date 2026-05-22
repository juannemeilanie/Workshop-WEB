<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Antrean extends Model
{
    protected $table = 'antrean';
    protected $fillable = ['nama', 'idpoli', 'nomor', 'status', 'tanggal_daftar'];

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'idpoli', 'idpoli');
    }

    public function scopeHariIni($query)
    {
        return $query->whereDate('tanggal_daftar', today());
    }
}
