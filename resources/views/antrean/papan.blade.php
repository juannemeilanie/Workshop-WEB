<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Papan Antrian — RS Digital</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f172a;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background: #1e3a8a;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-brand { }
        .navbar-brand h1 { font-size: 1.5rem; font-weight: 700; }
        .navbar-brand p { font-size: 0.8rem; opacity: 0.7; }
        .navbar-right { text-align: right; }
        .clock { font-size: 2rem; font-weight: 700; font-variant-numeric: tabular-nums; }
        .date { font-size: 0.8rem; opacity: 0.7; }
        .live-badge {
            background: #22c55e;
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 20px;
            margin-left: 10px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .main-content {
            flex: 1;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 0;
        }
        .panel-kiri {
            background: #1e293b;
            padding: 48px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-right: 1px solid #334155;
        }
        .nomor-label {
            font-size: 0.9rem;
            letter-spacing: 0.2em;
            color: #94a3b8;
            margin-bottom: 16px;
            text-transform: uppercase;
        }
        .nomor-besar {
            font-size: 12rem;
            font-weight: 900;
            color: #fbbf24;
            line-height: 1;
            margin-bottom: 16px;
            transition: all 0.5s ease;
        }
        .nama-besar {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            text-align: center;
        }
        .poli-besar {
            font-size: 1rem;
            color: #94a3b8;
            margin-bottom: 24px;
        }
        .btn-masuk {
            background: #fbbf24;
            color: #111827;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }
        .panel-kanan {
            background: #0f172a;
            padding: 24px;
            display: flex;
            flex-direction: column;
        }
        .menunggu-label {
            font-size: 0.8rem;
            color: #64748b;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #1e293b;
        }
        .antrian-item {
            background: #1e293b;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 12px;
        }
        .antrian-item .item-nomor { font-size: 1.5rem; font-weight: 900; color: #fbbf24; margin-bottom: 4px; }
        .antrian-item .item-nama { font-size: 0.95rem; color: white; font-weight: 600; }
        .antrian-item .item-poli { font-size: 0.8rem; color: #64748b; }
        .no-antrian { color: #64748b; text-align: center; padding: 32px; }
        .footer {
            background: #0f172a;
            border-top: 1px solid #1e293b;
            padding: 12px 32px;
            text-align: center;
            color: #475569;
            font-size: 0.8rem;
        }
        /* Overlay aktivasi suara */
        .overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
        }
        .overlay-card {
            background: #1e293b;
            padding: 40px;
            border-radius: 16px;
            text-align: center;
            max-width: 400px;
        }
        .overlay-card h2 { font-size: 1.5rem; font-weight: 700; margin-bottom: 12px; }
        .overlay-card p { color: #94a3b8; margin-bottom: 24px; }
        .overlay-btn {
            background: #2563eb;
            color: white;
            padding: 14px 32px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
        }
        @media (max-width: 768px) {
            .main-content { grid-template-columns: 1fr; }
            .nomor-besar { font-size: 7rem; }
        }
    </style>
</head>
<body>
    <div class="overlay" id="overlay">
        <div class="overlay-card">
            <h2>🔊 Papan Antrian Digital</h2>
            <p>Klik tombol di bawah untuk mengaktifkan tampilan dan notifikasi suara antrian.</p>
            <button class="overlay-btn" onclick="aktivasiPapan()">✅ Aktifkan Papan Antrian</button>
        </div>
    </div>

    <div class="navbar">
        <div class="navbar-brand">
            <h1>RS Digital</h1>
            <p>Sistem Antrian Digital</p>
        </div>
        <div class="navbar-right">
            <div class="clock" id="clock">--:--:--</div>
            <div class="date" id="date">--</div>
            <span class="live-badge">● Live</span>
        </div>
    </div>

    <div class="main-content">
        <div class="panel-kiri">
            <div class="nomor-label">NOMOR DIPANGGIL</div>
            <div class="nomor-besar" id="nomor-dipanggil">---</div>
            <div class="nama-besar" id="nama-dipanggil">Menunggu Panggilan</div>
            <div class="poli-besar" id="poli-dipanggil">—</div>
            <button class="btn-masuk">📢 Silakan Menuju Poli</button>
        </div>

        <div class="panel-kanan">
            <div class="menunggu-label">≡ ANTRIAN MENUNGGU</div>
            <div id="list-menunggu">
                <div class="no-antrian">Belum ada antrian</div>
            </div>
        </div>
    </div>

    <div class="footer">RS Digital — Antrian Digital Terpadu © 2026</div>
<audio id="audio-dingdong" autoplay>
    <source src="{{ asset('assets/sounds/dingdong.mp3') }}" type="audio/mpeg">
</audio>

    <script>
    let sudahAktif = false;
    let nomorSebelumnya = null;
    let source = null;

    function updateClock() {
        const now = new Date();

        document.getElementById('clock').textContent =
            now.toLocaleTimeString('id-ID');

        document.getElementById('date').textContent =
            now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
    }
    setInterval(updateClock, 1000);
    updateClock();

    function aktivasiPapan() {
        sudahAktif = true;
        document.getElementById('overlay').style.display = 'none';

        speechSynthesis.cancel();

        const unlock = new SpeechSynthesisUtterance('aktif');
        unlock.volume = 0;
        speechSynthesis.speak(unlock);

        const audio = document.getElementById('audio-dingdong');

        audio.play()
            .then(() => {
                audio.pause();
                audio.currentTime = 0;
            })
            .catch(err => {
                console.log(err);
            });

        hubungkanSSE();
    }

    function hubungkanSSE() {
        if (source) {
            source.close();
        }

        source = new EventSource('{{ route("sse.stream") }}');

        source.onopen = function() {
            console.log('SSE connected');
        };

        source.addEventListener('queue-update', function(event) {

            try {
                const data = JSON.parse(event.data);
                updatePapan(data);
            } catch(err) {
                console.log(err);
            }

        });

        source.onerror = function(err) {
            console.log('SSE disconnected');
            source.close();

            setTimeout(() => {
                hubungkanSSE();
            }, 3000);
        };
    }

    function updatePapan(data) {
        console.log(data);

        if (data.nomor_dipanggil) {

            const nomorFormatted =
                String(data.nomor_dipanggil).padStart(3, '0');

            document.getElementById('nomor-dipanggil').textContent =
                nomorFormatted;

            document.getElementById('nama-dipanggil').textContent =
                data.nama_dipanggil || '-';

            document.getElementById('poli-dipanggil').textContent =
                data.poli_dipanggil || '-';

            if (
                nomorSebelumnya != data.nomor_dipanggil &&
                sudahAktif
            ) {

                nomorSebelumnya = data.nomor_dipanggil;

                mainkanSuara(
                    nomorFormatted,
                    data.nama_dipanggil,
                    data.poli_dipanggil
                );
            }

        } else {
            document.getElementById('nomor-dipanggil').textContent = '---';
            document.getElementById('nama-dipanggil').textContent =
                'Menunggu Panggilan';
            document.getElementById('poli-dipanggil').textContent = '-';
        }

        const list = document.getElementById('list-menunggu');

        if (
            data.antrean_menunggu &&
            data.antrean_menunggu.length > 0
        ) {

            list.innerHTML =
                data.antrean_menunggu.map(a => `
                    <div class="antrian-item">
                        <div class="item-nomor">
                            ${String(a.nomor).padStart(3,'0')}
                        </div>

                        <div class="item-nama">
                            ${a.nama}
                        </div>

                        <div class="item-poli">
                            ${a.poli ?? '-'}
                        </div>
                    </div>
                `).join('');

        } else {

            list.innerHTML = `
                <div class="no-antrian">
                    Tidak ada antrian menunggu
                </div>
            `;
        }
    }

    function mainkanSuara(nomor, nama, poli) {
        const audio = document.getElementById('audio-dingdong');

        audio.pause();
        audio.currentTime = 0;

        audio.play()
            .then(() => {

                audio.onended = function() {

                    const text =
                        `Nomor antrian ${nomor}, ` +
                        `${nama}, ` +
                        `silahkan menuju ${poli}`;

                    const speech =
                        new SpeechSynthesisUtterance(text);

                    speech.lang = 'id-ID';
                    speech.rate = 0.85;
                    speech.pitch = 1;
                    speech.volume = 1;

                    speechSynthesis.cancel();
                    speechSynthesis.speak(speech);
                }

            })
            .catch(() => {

                const speech =
                    new SpeechSynthesisUtterance(
                        `Nomor antrian ${nomor}`
                    );

                speech.lang = 'id-ID';

                speechSynthesis.speak(speech);
            });
    }
    </script>
</body>
</html>