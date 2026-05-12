@extends('layout.main')

@section('title', 'Tambah Toko')

@section('content')
<div class="page-header">
    <h3 class="page-title">Tambah Toko</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('toko.index') }}">Kunjungan Toko</a></li>
            <li class="breadcrumb-item active">Tambah Toko</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">

        <form action="{{ route('toko.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Toko</label>
                <input type="text" name="nama_toko" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Latitude</label>
                <input type="number" step="any" name="latitude" id="input-lat" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Longitude</label>
                <input type="number" step="any" name="longitude" id="input-lng" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Accuracy (meter)</label>
                <input type="number" step="any" name="accuracy" id="input-acc" class="form-control" required>
            </div>

            <a href="{{ route('toko.index') }}" class="btn btn-rounded btn-gradient-secondary mt-2">Kembali</a>

            <button type="button" class="btn btn-rounded btn-gradient-warning mt-2" onclick="ambilLokasiToko()">
                 Ambil Lokasi Toko
            </button>
            <button type="submit" class="btn btn-rounded btn-gradient-primary mt-2">Submit</button>
        </form>

    </div>
</div>

<script>
    async function ambilLokasiToko() {
        alert('Mengambil lokasi toko, harap tunggu...');
        try {
            const pos = await getAccuratePosition(50);
            document.getElementById('input-lat').value = pos.coords.latitude;
            document.getElementById('input-lng').value = pos.coords.longitude;
            document.getElementById('input-acc').value = pos.coords.accuracy.toFixed(1);
        } catch (e) {
            alert('Gagal ambil lokasi: ' + e.message);
        }
    }

    function getAccuratePosition(targetAccuracy = 50, maxWait = 20000) {
        return new Promise((resolve, reject) => {
            let bestResult  = null;
            const startTime = Date.now();
            const watchId   = navigator.geolocation.watchPosition(
                (position) => {
                    if (!bestResult || position.coords.accuracy < bestResult.coords.accuracy)
                        bestResult = position;
                    if (position.coords.accuracy <= targetAccuracy) {
                        navigator.geolocation.clearWatch(watchId);
                        resolve(bestResult);
                    }
                    if (Date.now() - startTime >= maxWait) {
                        navigator.geolocation.clearWatch(watchId);
                        bestResult ? resolve(bestResult) : reject(new Error('Timeout, tidak dapat posisi'));
                    }
                },
                (error) => reject(error),
                { enableHighAccuracy: true, maximumAge: 0, timeout: maxWait }
            );
        });
    }
</script>
@endsection