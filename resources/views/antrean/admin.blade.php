@extends('layout.main')

@section('title', 'Kelola Antrian')

@section('content')

<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-hospital-building"></i>
        </span>
        Sistem Antrian 
    </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Sistem Antrian</a></li>
                <li class="breadcrumb-item active" aria-current="page">Kelola Antrian</li>
            </ol>
      </nav>
</div>

<div class="row mb-4">
    <div class="col-12 col-md-5 mb-2 mb-md-0">
        <button class="btn btn-gradient-warning w-100"
            onclick="panggilBerikutnya()">
            <i class="mdi mdi-bullhorn me-2"></i> Panggil Berikutnya
        </button>
    </div>

    <div class="col-12 col-md-4 mb-2 mb-md-0">
        <button class="btn btn-gradient-danger w-100"
            onclick="resetAntrian()">
            <i class="mdi mdi-refresh me-2"></i> Reset Antrean
        </button>
    </div>

    <div class="col-12 col-md-3">
        <a href="{{ route('papan') }}" target="_blank"
            class="btn btn-gradient-primary w-100">
            <i class="mdi mdi-monitor me-2"></i> Papan Antrean
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header bg-gradient-warning text-white">
        SEDANG DIPANGGIL
    </div>
    <div class="card-body" id="dipanggil-content">
        <p class="text-muted mb-0">Belum ada yang dipanggil</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-6 col-xl-3">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                Menunggu <h3 id="stat-menunggu">0</h3>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card bg-gradient-info text-white">
            <div class="card-body">
                Dipanggil <h3 id="stat-dipanggil">0</h3>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card bg-gradient-danger text-white">
            <div class="card-body">
                Terlambat <h3 id="stat-terlambat">0</h3>
            </div>
        </div>
    </div>

    <div class="col-6 col-xl-3">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                Selesai <h3 id="stat-selesai">0</h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4" id="section-terlambat" style="display:none;">
    <div class="card-header bg-gradient-danger text-white">
        Antrian Terlambat
    </div>
    <div class="card-body" id="list-terlambat"></div>
</div>

<div class="card">
    <div class="card-header">
        Daftar Antrian
        <span class="float-end" id="total-badge">0</span>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped" border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Poli</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tabel-antrian">
                <tr>
                    <td colspan="6" class="text-center">Belum ada antrian</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


@endsection

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

let lastHash = '';
const source = new EventSource('{{ route("sse.stream") }}');

window.addEventListener('beforeunload', () => source.close());

source.onmessage = null;

source.addEventListener('queue-update', (e) => {
    const data = JSON.parse(e.data);
    updateUI(data);
});

function simpleHash(data) {
    const list = data.semua_antrean || [];
    let hash = '';

    for (let i = 0; i < list.length; i++) {
        hash += list[i].id + ':' + list[i].status + '|';
    }

    return hash;
}

function stat(id, val) {
    const el = document.getElementById(id);
    if (el && el.textContent != val) el.textContent = val ?? 0;
}

function updateUI(data) {

    const hash = simpleHash(data);
    if (hash === lastHash) return;
    lastHash = hash;

    stat('stat-menunggu', data.jumlah_menunggu);
    stat('stat-dipanggil', data.jumlah_dipanggil);
    stat('stat-terlambat', data.jumlah_terlambat);
    stat('stat-selesai', data.jumlah_selesai);

    document.getElementById('total-badge').textContent =
        (data.total ?? 0) + ' antrean';

    renderDipanggil(data);
    renderTerlambat(data);
    renderTabel(data);
}

function renderDipanggil(data) {
    const el = document.getElementById('dipanggil-content');

    if (!data.nomor_dipanggil) {
        el.innerHTML = '<p class="text-muted">Belum ada</p>';
        return;
    }

    el.innerHTML = `
        <div class="d-flex align-items-center gap-3">
            <span class="nomor">${String(data.nomor_dipanggil).padStart(3,'0')}</span>
            <div>
                <div class="nama">${data.nama_dipanggil}</div>
                <div class="poli">${data.poli_dipanggil}</div>
                <span class="badge-status badge-dipanggil mt-1 d-inline-block">Dipanggil</span>
            </div>
        </div>
    `;
}

function renderTerlambat(data) {
    const section = document.getElementById('section-terlambat');
    const list = document.getElementById('list-terlambat');

    const arr = data.antrean_terlambat || [];

    if (!arr.length) {
        section.style.display = 'none';
        list.innerHTML = '';
        return;
    }

    section.style.display = 'block';

    let html = '';
    for (let a of arr) {
        html += `
        <div class="terlambat-item" ondblclick="panggilTerlambat(${a.id})">
            <span class="info">${a.nomor} — ${a.nama}</span>
            <button class="btn btn-gradient-primary btn-sm" onclick="panggilTerlambat(${a.id})">
                <i class="mdi mdi-bullhorn me-1"></i> Panggil
            </button>
        </div>`;
    }

    list.innerHTML = html;
}

function renderTabel(data) {
    const tbody = document.getElementById('tabel-antrian');
    const list = data.semua_antrean || [];

    if (!list.length) {
        tbody.innerHTML = '<tr><td colspan="6" class="text-center">Belum ada data antrean</td></tr>';
        return;
    }

    let html = '';

    for (let a of list) {
        let aksi = '—';

        if (a.status === 'menunggu') {
            aksi = `<button class="btn btn-gradient-primary btn-sm" onclick="panggilLangsung(${a.id})">
                        <i class="mdi mdi-bullhorn me-1"></i> Panggil
                    </button>`;
        }

        else if (a.status === 'dipanggil') {
            aksi = `<div class="d-flex gap-2">
                        <button class="btn btn-gradient-success btn-sm" onclick="tandaiSelesai(${a.id})">
                            <i class="mdi mdi-check me-1"></i> Selesai
                        </button>
                        <button class="btn btn-gradient-danger btn-sm" onclick="tandaiTerlambat(${a.id})">
                            <i class="mdi mdi-clock-alert me-1"></i> Terlambat
                        </button>
                    </div>`;
        }

        else if (a.status === 'terlambat') {
            aksi = `<button class="btn btn-gradient-secondary btn-sm" onclick="panggilTerlambat(${a.id})">
                        <i class="mdi mdi-refresh me-1"></i> Ulang
                    </button>`;
        }

        else {
            aksi = '<span class="badge-status badge-selesai">Selesai</span>';
        }

        const badgeClass = 'badge-' + a.status;

        html += `
        <tr>
            <td>${a.nomor}</td>
            <td>${a.nama}</td>
            <td>${a.poli ?? '-'}</td>
            <td>${a.jam_daftar}</td>
            <td><span class="badge-status ${badgeClass}">${a.status.charAt(0).toUpperCase() + a.status.slice(1)}</span></td>
            <td>${aksi}</td>
        </tr>`;
    }

    tbody.innerHTML = html;
}

async function panggilBerikutnya() {
    await fetch('{{ route("admin.panggil") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });
}

async function panggilLangsung(id) {
    await fetch(`/admin/panggil-terlambat/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });
}

async function tandaiSelesai(id) {
    await fetch(`/admin/selesai/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });
}

async function tandaiTerlambat(id) {
    await fetch(`/admin/terlambat/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });
}

async function panggilTerlambat(id) {
    await fetch(`/admin/panggil-terlambat/${id}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });
}

async function resetAntrian() {
    await fetch('{{ route("admin.reset") }}', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });
}
</script>
@endpush