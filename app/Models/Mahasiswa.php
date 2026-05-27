<?php

namespace App\Models;

use App\Models\Absensi;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'mahasiswa_id';
    protected $fillable = [
        'nim', 
        'nama', 
        'jurusan', 
        'nfc_serial',
    ];

    public $timestamps = true;

    public function absensis(){
        return $this->hasMany(Absensi::class, 'mahasiswa_id', 'mahasiswa_id');
    }
}
