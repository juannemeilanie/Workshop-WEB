<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomor Antrian — RS Digital</title>
<style>
    :root {
        --bs-purple: #6f42c1;
        --bs-indigo: #6610f2;
        --bs-primary: #6f42c1;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        background: linear-gradient(135deg, #4f46e5, #6f42c1);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        color: #fff;
    }

    .header {
        text-align: center;
        margin-bottom: 25px;
    }

    .header h1 {
        font-size: 2.2rem;
        font-weight: 700;
    }

    .header p {
        opacity: 0.85;
        font-size: 0.95rem;
    }

    .card {
        background: #fff;
        color: #212529;
        border-radius: 16px;
        padding: 35px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.25);
        border: 1px solid rgba(111,66,193,0.15);
    }

    .icon-success {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, #6f42c1, #6610f2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        margin: 0 auto 18px;
        box-shadow: 0 10px 25px rgba(111,66,193,0.3);
    }

    .card h2 {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 22px;
        text-align: center;
    }

    .ticket-box {
        border: 2px dashed #6f42c1;
        border-radius: 14px;
        background: rgba(111,66,193,0.05);
        padding: 22px;
        margin-bottom: 20px;
    }

    .ticket-label {
        font-size: 0.75rem;
        font-weight: 700;
        color: #6f42c1;
        letter-spacing: 0.1em;
        margin-bottom: 8px;
        text-align: center;
    }

    .ticket-number {
        font-size: 4.5rem;
        font-weight: 900;
        color: #4f46e5;
        text-align: center;
        line-height: 1;
        margin-bottom: 15px;
    }

    .ticket-info {
        font-size: 0.9rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 4px 0;
        border-bottom: 1px dashed #eee;
    }

    .label {
        color: #6b7280;
    }

    .value {
        font-weight: 600;
        color: #111827;
    }

    .notice {
        color: #6b7280;
        font-size: 0.85rem;
        text-align: center;
        margin-bottom: 18px;
    }

    .actions {
        display: flex;
        gap: 10px;
        margin-bottom: 12px;
    }

    .btn {
        flex: 1;
        padding: 12px;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: 0.2s;
    }

    .btn:hover {
        transform: translateY(-1px);
    }

    .btn-outline {
        background: white;
        border: 2px solid #6f42c1;
        color: #6f42c1;
    }

    .btn-outline:hover {
        background: #6f42c1;
        color: white;
    }

    .btn-green {
        background: linear-gradient(135deg, #6f42c1, #4f46e5);
        color: white;
    }

    .btn-link {
        display: block;
        text-align: center;
        padding: 10px;
        border: 2px solid #6f42c1;
        border-radius: 10px;
        text-decoration: none;
        color: #6f42c1;
        font-size: 0.9rem;
        transition: 0.2s;
    }

    .btn-link:hover {
        background: #6f42c1;
        color: white;
    }
</style>
</head>
<body>
    <div class="header">
        <h1>RS Digital</h1>
        <p>Sistem Antrian Digital</p>
    </div>

    <div class="card">
        <div class="icon-success">✓</div>
        <h2>Pendaftaran Berhasil!</h2>

        <div class="ticket-box">
            <div class="ticket-label">NOMOR ANTRIAN ANDA</div>
            <div class="ticket-number">{{ str_pad($antrean->nomor, 3, '0', STR_PAD_LEFT) }}</div>
            <div class="ticket-info">
                <div>
                    <div class="info-row">
                        <span class="label">Nama </span>
                        <span class="value">{{ $antrean->nama }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Poli</span>
                        <span class="value">{{ $antrean->poli->nama_poli }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Waktu Daftar</span>
                        <span class="value">{{ $antrean->created_at->format('H.i.s') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <p class="notice">Harap menunggu. Nomor akan dipanggil melalui pengeras suara dan papan antrian.</p>

        <div class="actions">
            <button class="btn btn-outline" onclick="window.print()">🖨️ Cetak</button>
            <a href="{{ route('guest') }}" class="btn btn-gradient-green" style="text-decoration:none;text-align:center;line-height:2.5">➕ Daftar Lagi</a>
        </div>
        <a href="{{ route('papan') }}" class="btn-link">🖥️ Lihat Papan Antrian</a>
    </div>
</body>
</html>