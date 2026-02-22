<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        body {
            font-family: "Times New Roman", serif;
            text-align: center;
            color: #000;
            width: 100%;
            height: 100%;
            padding: 0px;
        }

        .certificate {
            border: 8px double #000;
            padding: 40px;
        }

        .title {
            font-size: 40px;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 20px;
        }

        .subtitle {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .name {
            font-size: 32px;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
        }

        .line {
            width: 60%;
            margin: 10px auto 25px;
            border-bottom: 2px solid #000;
        }

        .content {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .date {
            font-size: 16px;
            margin-top: 20px;
        }

        table{
            width:100%; 
            margin-top: 80px; 
            text-align: center;
        }

        .sign .line-sign {
            margin-top: 60px;
            border-top: 2px solid #000;
            width: 200px;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>

<div class="certificate">
    <div class="title">SERTIFIKAT</div>
    <div class="subtitle">Diberikan Kepada</div>

    <div class="name">JUANNE MEILANIE</div>
    <div class="line"></div>

    <div class="content">
        Atas partisipasi dan kontribusi aktif dalam kegiatan akademik  
        yang diselenggarakan dengan penuh tanggung jawab dan dedikasi.
    </div>

    <div class="date">
        Diberikan pada: {{ date('d F Y') }}
    </div>

    <table>
        <tr>
            <td width="50%">
                Mengetahui<br>
                Ketua Panitia
                <div style="margin-top: 60px; border-top: 2px solid #000; width: 200px; margin-left: auto; margin-right: auto;"></div>
            </td>

            <td width="50%">
                Penanggung Jawab
                <div style="margin-top: 60px; border-top: 2px solid #000; width: 200px; margin-left: auto; margin-right: auto;"></div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>