@extends('layout.main')
@section('title', 'Scan Absensi NFC')

@section('content')
<div class="page-header">
    <h3 class="page-title">Scan Absensi NFC</h3>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('mahasiswa.index') }}">NFC</a>
            </li>
            <li class="breadcrumb-item active">
                Scan Absensi NFC
            </li>
        </ol>
    </nav>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">Scan Absensi NFC</h5>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label>Mata Kuliah</label>
                    <input type="text" id="mata-kuliah" class="form-control" placeholder="Contoh: Pemrograman Web" required >
                </div>

                <button class="btn btn-rounded btn-gradient-primary w-100 mb-3"  onclick="startScan()" id="scan-btn">Aktifkan NFC Scanner</button>

                <div id="status-box" class="alert alert-secondary text-center" style="display:none">
                    <span id="status-msg">
                        Menunggu kartu...
                    </span>
                </div>

                <div id="result-box" class="d-none mt-3">
                    <hr>
                    <h6 class="text-success fw-bold">
                        Absensi Berhasil
                    </h6>

                    <table class="table table-striped">
                        <tbody>

                            <tr>
                                <td><b>NIM</b></td>
                                <td>
                                    <span id="res-nim"></span>
                                </td>
                            </tr>

                            <tr>
                                <td><b>Nama</b></td>
                                <td>
                                    <span id="res-nama"></span>
                                </td>
                            </tr>

                            <tr>
                                <td><b>Waktu</b></td>
                                <td>
                                    <span id="res-waktu"></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-rounded btn-secondary w-100" onclick="scanLagi()">Scan Mahasiswa Lain</button>
                </div>

                <div id="error-box" class="alert alert-danger d-none mt-3">
                    <span id="error-msg"></span>
                    <div class="mt-2">
                        <button class="btn btn-rounded btn-sm btn-danger" onclick="scanLagi()">Coba Lagi</button>
                    </div>
                </div>
                <hr>
                <a href="{{ route('absensi.index') }}" class="btn btn-rounded btn-secondary w-100"> Lihat Riwayat Absensi</a>
            </div>
        </div>
    </div>
</div>

<audio id="beep" src="{{ asset('assets/sounds/beep-329314.mp3') }}" preload="auto"></audio>

<script>

    let ndef = null;
    let scanning = false;

    async function startScan() {

        const matkul = document
            .getElementById('mata-kuliah')
            .value
            .trim();

        if (!matkul) {
            alert('Isi mata kuliah terlebih dahulu!');
            return;
        }

        if (!('NDEFReader' in window)) {
            showError(
                'Browser tidak mendukung Web NFC. Gunakan Chrome Android.'
            );

            return;
        }

        document
            .getElementById('result-box')
            .classList
            .add('d-none');
        document
            .getElementById('error-box')
            .classList
            .add('d-none');

        const statusBox = document.getElementById('status-box');
        statusBox.style.display = 'block';
        statusBox.className =
            'alert alert-secondary text-center';
        document.getElementById('status-msg').textContent =
            'NFC aktif. Dekatkan kartu mahasiswa...';

        try {
            ndef = new NDEFReader();
            scanning = true;
            await ndef.scan();

            ndef.addEventListener('reading', async (event) => {
                if (!scanning) return;

                scanning = false;

                console.log(event);
                const serialNumber = event.serialNumber;
                console.log("SERIAL:", serialNumber);

                if (!serialNumber || serialNumber === '') {
                    showError(
                        'Serial NFC tidak terbaca. Coba kartu lain / HP lain.'
                    );

                    return;
                }

                const beep = document.getElementById('beep');

                beep.currentTime = 0;
                beep.play().catch(() => {});
                prosesAbsensi(serialNumber, matkul);

            });

        } catch (err) {
            console.error(err);
            showError(
                'Error NFC: ' + err.message
            );
        }
    }

    async function prosesAbsensi(serialNumber, matkul) {
        document.getElementById('status-msg').textContent =
            'Memproses absensi...';

        try {
            console.log('Serial NFC:', serialNumber);
            const response = await fetch(
                "https://winston-nonreasonable-otelia.ngrok-free.dev/absensi/proses",
                {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },

                    body: JSON.stringify({
                        nfc_serial: serialNumber,
                        matakuliah: matkul
                    })
                }
            );

            console.log("STATUS:", response.status);
            const data = await response.json();
            console.log(data);

            if (data.success) {
                document.getElementById('res-nim').textContent =
                    data.mahasiswa.nim;
                document.getElementById('res-nama').textContent =
                    data.mahasiswa.nama;
                document.getElementById('res-waktu').textContent =
                    data.mahasiswa.waktu_absen;
                document
                    .getElementById('result-box')
                    .classList
                    .remove('d-none');
                document.getElementById('status-box').style.display =
                    'none';
            } else {
                showError(data.message);
            }

        } catch (err) {
            console.error(err);
            showError(
                'Gagal koneksi: ' + err.message
            );
        }
    }

    function showError(msg) {
        document.getElementById('error-msg').textContent =
            msg;
        document
            .getElementById('error-box')
            .classList
            .remove('d-none');
        document.getElementById('status-box').style.display =
            'none';
        scanning = false;
    }

    function scanLagi() {
        document
            .getElementById('result-box')
            .classList
            .add('d-none');

        document
            .getElementById('error-box')
            .classList
            .add('d-none');

        startScan();
    }

</script>
@endsection