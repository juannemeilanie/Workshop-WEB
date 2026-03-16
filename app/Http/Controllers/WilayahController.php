<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    private array $config = [
        'provinsi' => [
            'table' => 'reg_provinces',
            'kode'  => 'id',
            'nama'  => 'name',
        ],
        'kabupaten' => [
            'table' => 'reg_regencies',
            'kode'  => 'id',
            'nama'  => 'name',
            'fk'    => 'province_id',   
        ],
        'kecamatan' => [
            'table' => 'reg_districts',
            'kode'  => 'id',
            'nama'  => 'name',
            'fk'    => 'regency_id',   
        ],
        'kelurahan' => [
            'table' => 'reg_villages',
            'kode'  => 'id',
            'nama'  => 'name',
            'fk'    => 'district_id',   
        ],
    ];


    private function jsonResponse(string $status, int $code, string $message, $data)
    {
        return response()->json([
            'status'  => $status,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    public function index()
    {
        return view('wilayah.index');
    }

    public function getProvinsi()
    {
        $cfg  = $this->config['provinsi'];
        $rows = DB::table($cfg['table'])
                    ->select(
                        "{$cfg['kode']} as kode",
                        "{$cfg['nama']} as nama"
                    )
                    ->orderBy($cfg['nama'])
                    ->get();

        return $this->jsonResponse('success', 200, 'Data provinsi berhasil diambil', $rows);
    }

    public function getKota(Request $req)
    {
        $req->validate(['kode_provinsi' => 'required|string']);
        $cfg  = $this->config['kabupaten'];
        $rows = DB::table($cfg['table'])
                    ->select(
                        "{$cfg['kode']} as kode",
                        "{$cfg['nama']} as nama"
                    )
                    ->where($cfg['fk'], $req->kode_provinsi)
                    ->orderBy($cfg['nama'])
                    ->get();

        return $this->jsonResponse('success', 200, 'Data kota berhasil diambil', $rows);
    }

    public function getKecamatan(Request $req)
    {
        $req->validate(['kode_kabupaten' => 'required|string']);
        $cfg  = $this->config['kecamatan'];
        $rows = DB::table($cfg['table'])
                    ->select(
                        "{$cfg['kode']} as kode",
                        "{$cfg['nama']} as nama"
                    )
                    ->where($cfg['fk'], $req->kode_kabupaten)
                    ->orderBy($cfg['nama'])
                    ->get();

        return $this->jsonResponse('success', 200, 'Data kecamatan berhasil diambil', $rows);
    }

    public function getKelurahan(Request $req)
    {
        $req->validate(['kode_kecamatan' => 'required|string']);
        $cfg  = $this->config['kelurahan'];
        $rows = DB::table($cfg['table'])
                    ->select(
                        "{$cfg['kode']} as kode",
                        "{$cfg['nama']} as nama"
                    )
                    ->where($cfg['fk'], $req->kode_kecamatan)
                    ->orderBy($cfg['nama'])
                    ->get();

        return $this->jsonResponse('success', 200, 'Data kelurahan berhasil diambil', $rows);
    }
}