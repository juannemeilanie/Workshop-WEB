@extends('layout.main')
@section('title', 'Scan QRCode Customer')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white text-center">
                    <h5 class="mb-0"> Scan QRCode</h5>
                </div>
                <div class="card-body">

                    <div id="reader" style="width:100%;"></div>
                    <p class="text-center text-muted small mt-2">
                        Arahkan kamera ke QRCode customer
                    </p>

                    <div id="error-box" class="alert alert-danger d-none mt-3">
                        <span id="error-msg"></span>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-danger" onclick="resetScanner()">Coba Lagi</button>
                        </div>
                    </div>

                    <div id="result-box" class="d-none mt-3">
                        <hr>
                        <h6 class="text-success fw-bold">QRCode Berhasil Dibaca!</h6>
                        <p><b>ID:</b> <span id="res-id"></span></p>
                        <p><b>Nama:</b> <span id="res-nama"></span></p>
                        <p><b>Status:</b> <span id="res-status" class="badge"></span></p>

                        <table class="table table-sm">
                            <tbody id="res-items"></tbody>
                        </table>

                        <p><b>Total: <span id="res-total"></span></b></p>

                        <button class="btn btn-rounded btn-gradient-primary w-100" onclick="resetScanner()">
                            Scan Lagi
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<audio id="beep" src="{{ asset('assets/sounds/beep-329314.mp3') }}" preload="auto"></audio>

<!-- HANYA html5-qrcode -->
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
        { fps: 10, qrbox: { width: 250, height: 250 } },
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

    fetch("/vendor/pesanan/scan/read", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ idpesanan: parseInt(text) })
    })
    .then(res => {
        if (!res.ok) throw new Error("HTTP " + res.status);
        return res.json();
    })
    .then(data => {
        if (data.success) showResult(data.data);
        else showError(data.message);
    })
    .catch(err => showError("Gagal ke server: " + err.message));

    if (scanner) {
        scanner.stop().then(() => scanner = null).catch(() => scanner = null);
    }
}

function showResult(data) {
    document.getElementById('res-id').textContent   = data.idpesanan;
    document.getElementById('res-nama').textContent = data.nama;

    const statusEl = document.getElementById('res-status');
    statusEl.textContent = data.status_bayar;
    statusEl.className   = 'badge ' + (data.is_lunas ? 'bg-success' : 'bg-danger');

    let rows = '';
    data.items.forEach(i => {
        rows += `<tr>
            <td>${i.nama_menu} x${i.jumlah}</td>
            <td class="text-end">Rp ${parseInt(i.subtotal).toLocaleString('id-ID')}</td>
        </tr>`;
    });

    document.getElementById('res-items').innerHTML = rows;
    document.getElementById('res-total').textContent =
        'Rp ' + parseInt(data.total).toLocaleString('id-ID');

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