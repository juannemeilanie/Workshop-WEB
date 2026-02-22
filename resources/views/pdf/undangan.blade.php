<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4;
            margin: 40px;
        }

        body {
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #000;
            padding: 5px;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .header h2 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 4px 0;
            font-size: 12pt;
        }

        .content {
            margin-top: 20px;
        }

        .content p {
            margin: 10px 0;
            text-align: justify;
        }

        .info-table {
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }

        .footer {
            margin-top: 50px;
            width: 100%;
        }

        .signature {
            width: 40%;
            float: right;
            text-align: center;
        }

        .signature .line {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 100%;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Fakultas Vokasi</h2>
        <p>Universitas Airlangga</p>
        <p>Surabaya</p>
    </div>

    <div class="content">
        <p>
            Nomor : 001/UN3.FV/UND/2026<br>
            Lampiran : -<br>
            Perihal : Undangan
        </p>

        <p>Yth.<br>
        Bapak/Ibu ........................................<br>
        di Tempat
        </p>

        <p>
            Dengan hormat,<br><br>
            Sehubungan dengan akan diselenggarakannya kegiatan akademik Fakultas Vokasi Universitas Airlangga, 
            dengan ini kami mengundang Bapak/Ibu untuk berkenan hadir pada kegiatan yang akan dilaksanakan pada:
        </p>

        <table class="info-table">
            <tr>
                <td width="120px">Hari / Tanggal</td>
                <td>: ........................................</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>: ........................................</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>: ........................................</td>
            </tr>
            <tr>
                <td>Acara</td>
                <td>: ........................................</td>
            </tr>
        </table>

        <p>
            Demikian undangan ini kami sampaikan. 
            Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.
        </p>
    </div>

    <div class="footer">
        <div class="signature">
            <p>Surabaya, {{ date('d F Y') }}<br>
            Mengetahui,<br>
            Dekan Fakultas Vokasi</p>

            <div class="line"></div>
            <p><strong>Nama Dekan</strong><br>
            NIP. 19xxxxxxxxxxxx</p>
        </div>
        <div class="clear"></div>
    </div>

</body>
</html>