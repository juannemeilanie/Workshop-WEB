@extends('layout.main')
@section('title', 'Titik Kunjungan')

@section('content')
<div class="page-header">
    <h3 class="page-title">Scan Barcode Toko</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('toko.index') }}">Kunjungan Toko</a></li>
            <li class="breadcrumb-item active">Scan Barcode Toko</li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">

            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0">Scan Barcode Toko</h5>
                </div>
                <div class="card-body">

                    <div id="reader" style="width:100%;"></div>
                    <p class="text-center text-muted small mt-2">
                        Arahkan kamera ke barcode toko
                    </p>

                    <div id="error-box" class="alert alert-danger d-none mt-3">
                        <span id="error-msg"></span>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-rounded btn-gradient-danger" onclick="resetScanner()">Coba Lagi</button>
                        </div>
                    </div>

                    <div id="result-box" class="d-none mt-3">
                        <hr>
                        <h6 class="text-success fw-bold">Detail Toko</h6>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td><b>Barcode:</b></td>
                                    <td><span id="res-barcode"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Nama Toko:</b></td>
                                    <td><span id="res-nama"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Latitude:</b></td>
                                    <td><span id="res-lat"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Longitude:</b></td>
                                    <td><span id="res-lng"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Accuracy Toko:</b></td>
                                    <td><span id="res-acc"></span> m</td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-rounded btn-gradient-secondary w-100" onclick="resetScanner()"> Scan Lagi</button>
                    </div>

                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h5 class="mb-0">Lokasi & Kunjungan</h5>
                </div>
                <div class="card-body">

                    <button class="btn btn-rounded btn-gradient-primary w-100" onclick="ambilLokasiSales()">
                        Ambil Lokasi Saya
                    </button>

                    <div id="info-lokasi" class="alert alert-secondary d-none mt-3">
                        <strong>Posisi Saya:</strong>
                        <p id="lokasi-detail" class="mb-0"></p>
                    </div>

                    <hr>

                    <button class="btn btn-rounded btn-gradient-success w-100" onclick="submitKunjungan()">
                        Submit Kunjungan
                    </button>

                    <div id="hasil-kunjungan" class="alert d-none mt-3">
                        <strong>Hasil Kunjungan:</strong>
                        <div id="hasil-detail" class="mt-2"></div>
                    </div>

                    <hr>
                    <a href="{{ route('toko.index') }}" class="btn btn-rounded btn-gradient-secondary w-100">Kembali</a>

                </div>
            </div>

        </div>
    </div>
</div>

<audio id="beep" src="{{ asset('assets/sounds/beep-329314.mp3') }}" preload="auto"></audio>

<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    let scanner   = null;
    let sudahScan = false;
    let salesPos  = null;
    let tokoData  = null;

    function startScanner() {
        sudahScan = false;
        document.getElementById('result-box').classList.add('d-none');
        document.getElementById('error-box').classList.add('d-none');

        scanner = new Html5Qrcode("reader");
        scanner.start(
            { facingMode: "environment" },
            { fps: 10, qrbox: { width: 400, height: 200 } },
            onScan,
            () => {}
        );
    }

    function onScan(text) {
        if (sudahScan) return;
        sudahScan = true;

        const beep = document.getElementById('beep');
        beep.currentTime = 0;
        beep.play().catch(() => {});

        if (scanner) {
            scanner.stop().then(() => scanner = null).catch(() => scanner = null);
        }

        cariToko(text);
    }

    function resetScanner() {
        tokoData = null;
        document.getElementById('hasil-kunjungan').classList.add('d-none');
        if (scanner) {
            scanner.stop().catch(() => {}).finally(() => startScanner());
        } else {
            startScanner();
        }
    }

    async function cariToko(barcode) {
        const res  = await fetch(`{{ route('toko.barcode') }}?barcode=${barcode}`);
        const data = await res.json();

        if (data.error) {
            showError(data.error);
            return;
        }

        tokoData = data;

        document.getElementById('res-barcode').textContent = data.barcode;
        document.getElementById('res-nama').textContent    = data.nama_toko;
        document.getElementById('res-lat').textContent     = data.latitude;
        document.getElementById('res-lng').textContent     = data.longitude;
        document.getElementById('res-acc').textContent     = data.accuracy;
        document.getElementById('result-box').classList.remove('d-none');
    }

    function showError(msg) {
        document.getElementById('error-msg').textContent = msg;
        document.getElementById('error-box').classList.remove('d-none');
        sudahScan = false;
    }

    async function ambilLokasiSales() {
        document.getElementById('info-lokasi').classList.remove('d-none');
        document.getElementById('lokasi-detail').innerText = 'Mengambil lokasi... harap tunggu';
        try {
            salesPos = await getAccuratePosition(50);
            document.getElementById('lokasi-detail').innerHTML =
                `Lat: <b>${salesPos.coords.latitude}</b> | 
                 Lng: <b>${salesPos.coords.longitude}</b> | 
                 Accuracy: <b>${salesPos.coords.accuracy.toFixed(1)} m</b>`;
        } catch (e) {
            document.getElementById('lokasi-detail').innerText = 'Gagal: ' + e.message;
        }
    }

    async function submitKunjungan() {
        if (!tokoData) { alert('Scan barcode toko terlebih dahulu!'); return; }
        if (!salesPos) { alert('Ambil lokasi Anda terlebih dahulu!'); return; }

        const res = await fetch('{{ route('toko.cek') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                barcode:         tokoData.barcode,
                sales_latitude:  salesPos.coords.latitude,
                sales_longitude: salesPos.coords.longitude,
                sales_accuracy:  salesPos.coords.accuracy,
            })
        });

        const data    = await res.json();
        const hasilBox = document.getElementById('hasil-kunjungan');
        hasilBox.classList.remove('d-none');
        hasilBox.className = `alert mt-3 ${data.status === 'diterima' ? 'alert-success' : 'alert-danger'}`;

        document.getElementById('hasil-detail').innerHTML = `
            <table class="table table-sm mb-0">
                <tr><td><b>Toko</b></td><td>${data.toko}</td></tr>
                <tr><td><b>Jarak Aktual</b></td><td>${data.jarak_aktual} m</td></tr>
                <tr><td><b>Threshold Efektif</b></td><td>${data.threshold_efektif} m</td></tr>
                <tr><td><b>Status</b></td><td><b>${data.status.toUpperCase()}</b></td></tr>
            </table>
        `;
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

    startScanner();
</script>
@endsection