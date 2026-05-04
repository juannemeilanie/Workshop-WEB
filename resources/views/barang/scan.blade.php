@extends('layout.main')
@section('title', 'Scan Barcode')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0"> Scan Barcode</h5>
                </div>

                <div class="card-body">

                    <div id="reader" style="width:100%;"></div>
                    <p class="text-center text-muted small mt-2">
                        Arahkan kamera ke barcode barang
                    </p>

                    
                    <div id="error-box" class="alert alert-danger d-none mt-3">
                        <span id="error-msg"></span>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-gradient-danger" onclick="resetScanner()">Coba Lagi</button>
                        </div>
                    </div>

                    <div id="result-box" class="d-none mt-3">
                        <hr>
                        <h6 class="text-success fw-bold">Detail Barang</h6>
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td><b>ID Barang:</b></td>
                                    <td><span id="res-id"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Nama:</b></td>
                                    <td><span id="res-nama"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Harga:</b></td>
                                    <td><span id="res-harga"></span></td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-rounded btn-gradient-primary w-100 mt-2" onclick="resetScanner()">
                            Scan Lagi
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<audio id="beep" src="{{ asset('assets/sounds/beep-329314.mp3') }}" preload="auto"></audio>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let scanner;
let sudahScan = false;

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

    fetch("/barang/scan/find", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ barcode: text })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showResult(data.data);
        } else {
            showError("Barang tidak ditemukan");
        }
    })
    .catch(() => showError("Gagal koneksi ke server"));

    if (scanner) {
        scanner.stop().then(() => scanner = null).catch(() => scanner = null);
    }
}

function showResult(data) {
    document.getElementById('res-id').textContent = data.id;
    document.getElementById('res-nama').textContent = data.nama;
    document.getElementById('res-harga').textContent =
        "Rp " + parseInt(data.harga).toLocaleString('id-ID');

    document.getElementById('result-box').classList.remove('d-none');
}

function showError(msg) {
    document.getElementById('error-msg').textContent = msg;
    document.getElementById('error-box').classList.remove('d-none');
    sudahScan = false;
}

function resetScanner() {
    if (scanner) {
        scanner.stop().catch(() => {}).finally(() => startScanner());
    } else {
        startScanner();
    }
}

startScanner();
</script>
@endsection