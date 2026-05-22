<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrian — RS Digital</title>
<style>
    :root {
        --primary: #6f42c1;
        --primary-dark: #4f46e5;
        --bg-gradient: linear-gradient(135deg, #4f46e5, #6f42c1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        background: var(--bg-gradient);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .header {
        text-align: center;
        color: white;
        margin-bottom: 24px;
    }

    .header h1 {
        font-size: 2.2rem;
        font-weight: 800;
    }

    .header p {
        font-size: 1rem;
        opacity: 0.85;
    }

    .card {
        background: white;
        border-radius: 18px;
        padding: 38px;
        width: 100%;
        max-width: 500px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        border: 1px solid rgba(111,66,193,0.15);
    }

    .card h2 {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 6px;
    }

    .card p {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 26px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        font-size: 0.9rem;
    }

    input, select {
        width: 100%;
        padding: 12px 14px;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.95rem;
        outline: none;
        transition: 0.2s;
        background: #fff;
    }

    input:focus, select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(111,66,193,0.15);
    }

    .btn-primary {
        width: 100%;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: white;
        padding: 13px;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(111,66,193,0.25);
    }

    .btn-secondary {
        display: block;
        text-align: center;
        margin-top: 12px;
        padding: 11px;
        border: 2px solid var(--primary);
        border-radius: 10px;
        text-decoration: none;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.9rem;
        transition: 0.2s;
    }

    .btn-secondary:hover {
        background: var(--primary);
        color: white;
    }

    footer {
        color: rgba(255,255,255,0.7);
        font-size: 0.8rem;
        margin-top: 20px;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .card {
            padding: 25px;
        }

        .header h1 {
            font-size: 1.8rem;
        }
    }
</style>
</head>
<body>
    <div class="header">
        <h1>RS Digital</h1>
        <p>Sistem Antrian Digital</p>
    </div>

    <div class="card">
        <h2>Ambil Nomor Antrian</h2>
        <p>Isi data diri Anda untuk mendapatkan nomor antrian</p>

        <form action="{{ route('guest.daftar') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>👤 Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan nama lengkap Anda" required>
            </div>
            <div class="form-group">
                <label>Pilih Poli / Layanan</label>
                <select name="idpoli" required>
                    <option value="">-- Pilih Poli --</option>
                    @foreach($poli_list as $poli)
                        <option value="{{ $poli->idpoli }}">
                            {{ $poli->nama_poli }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn-primary">✈️ Ambil Nomor Antrian</button>
        </form>

        <a href="{{ route('papan') }}" class="btn-secondary">🖥️ Lihat Papan Antrian</a>
    </div>

    <footer>© 2026 RS Digital — Sistem Antrian</footer>
</body>
</html>