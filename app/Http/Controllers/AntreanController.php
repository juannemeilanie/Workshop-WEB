<?php

namespace App\Http\Controllers;

use App\Models\Antrean;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AntreanController extends Controller
{
    private function updateCache()
    {
        $semua     = Antrean::with('poli')->hariIni()->orderBy('nomor')->get();
        $menunggu  = $semua->where('status', 'menunggu');
        $dipanggil = $semua->where('status', 'dipanggil')->last();
        $terlambat = $semua->where('status', 'terlambat');
        $selesai   = $semua->where('status', 'selesai');

        $data = [
            'nomor_dipanggil'      => $dipanggil?->nomor,
            'nama_dipanggil'       => $dipanggil?->nama,
            'poli_dipanggil'       => $dipanggil?->poli?->nama_poli,
            'antrean_id_dipanggil' => $dipanggil?->id,

            'antrean_menunggu' => $menunggu->values()->map(fn($a) => [
                'id'    => $a->id,
                'nomor' => str_pad($a->nomor, 3, '0', STR_PAD_LEFT),
                'nama'  => $a->nama,
                'poli'  => $a->poli?->nama_poli,
            ])->toArray(),

            'antrean_terlambat' => $terlambat->values()->map(fn($a) => [
                'id'    => $a->id,
                'nomor' => str_pad($a->nomor, 3, '0', STR_PAD_LEFT),
                'nama'  => $a->nama,
                'poli'  => $a->poli?->nama_poli,
            ])->toArray(),

            'jumlah_menunggu'  => $menunggu->count(),
            'jumlah_dipanggil' => $dipanggil ? 1 : 0,
            'jumlah_terlambat' => $terlambat->count(),
            'jumlah_selesai'   => $selesai->count(),
            'total'            => $semua->count(),

            'semua_antrean' => $semua->map(fn($a) => [
                'id'           => $a->id,
                'nomor'        => str_pad($a->nomor, 3, '0', STR_PAD_LEFT),
                'nama'         => $a->nama,
                'poli'         => $a->poli?->nama_poli,
                'status'       => $a->status,
                'tanggal_daftar' => $a->tanggal_daftar,
                'jam_daftar'   => $a->created_at->format('H.i'),
            ])->toArray(),

            'updated_at' => now()->toISOString(),
        ];

        Cache::put('antrean_data', $data, now()->addHours(24));
        return $data;
    }

    public function guest()
    {
        $poli_list = Poli::select('idpoli', 'nama_poli')->get(); 
        return view('antrean.guest', compact('poli_list'));
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:100',
            'idpoli' => 'required|exists:poli,idpoli',
        ]);

        $nomor = Antrean::hariIni()->count() + 1;

        $antrean = Antrean::create([
            'nama'           => $request->nama,
            'idpoli'         => $request->idpoli,
            'nomor'          => $nomor,
            'status'         => 'menunggu',
            'tanggal_daftar' => today(),
        ]);

        $antrean->load('poli');

        $this->updateCache();

        return view('antrean.tiket', compact('antrean'));
    }

    public function admin()
    {
        return view('antrean.admin');
    }

    public function panggil(Request $request)
    {
        Antrean::hariIni()
            ->where('status', 'dipanggil')
            ->update(['status' => 'selesai']);

        $antrean = Antrean::with('poli')
            ->hariIni()
            ->where('status', 'menunggu')
            ->orderBy('nomor')
            ->first();

        if (!$antrean) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada antrean yang menunggu.',
            ]);
        }

        $antrean->update(['status' => 'dipanggil']);
        $this->updateCache();

        return response()->json([
            'success' => true,
            'antrean' => [
                'nomor' => str_pad($antrean->nomor, 3, '0', STR_PAD_LEFT),
                'nama'  => $antrean->nama,
                'poli'  => $antrean->poli?->nama_poli,
            ],
        ]);
    }

    public function tandaiTerlambat($id)
    {
        $antrean = Antrean::findOrFail($id);
        $antrean->update(['status' => 'terlambat']);
        $this->updateCache();

        return response()->json(['success' => true]);
    }

    public function panggilTerlambat($id)
    {
        Antrean::hariIni()
            ->where('status', 'dipanggil')
            ->update(['status' => 'selesai']);

        $antrean = Antrean::with('poli')->findOrFail($id);
        $antrean->update(['status' => 'dipanggil']);
        $this->updateCache();

        return response()->json([
            'success' => true,
            'antrean' => [
                'nomor' => str_pad($antrean->nomor, 3, '0', STR_PAD_LEFT),
                'nama'  => $antrean->nama,
                'poli'  => $antrean->poli?->nama_poli,
            ],
        ]);
    }

    public function reset()
    {
        Antrean::hariIni()->delete();
        $this->updateCache();

        return response()->json([
            'success' => true,
            'message' => 'Antrean hari ini berhasil direset.',
        ]);
    }

    public function selesaikan($id)
    {
        $antrean = Antrean::findOrFail($id);

        $antrean->update([
            'status' => 'selesai'
        ]);

        $this->updateCache();

        return response()->json([
            'success' => true
        ]);
    }

    public function papan()
    {
        return view('antrean.papan');
    }

    public function stream()
    {
        return response()->stream(function () {
            set_time_limit(0);

            while (ob_get_level() > 0) {
                ob_end_flush();
            }

            ob_implicit_flush(true);
            $lastHash = null;

            while (true) {

                if (connection_aborted()) break;

                $data = Cache::get('antrean_data', []);

                $hash = md5(json_encode($data));

                if ($hash !== $lastHash) {
                    echo "event: queue-update\n";
                    echo "data: " . json_encode($data) . "\n\n";
                    ob_flush();
                    flush();
                    $lastHash = $hash;
                }

                sleep(1);
            }

        }, 200, [
            'Content-Type'      => 'text/event-stream',
            'Cache-Control'     => 'no-cache',
            'Connection'        => 'keep-alive',
            'X-Accel-Buffering' => 'no',
        ]);
    }
}

