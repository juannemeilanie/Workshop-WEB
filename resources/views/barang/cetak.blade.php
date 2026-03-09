
<!DOCTYPE html>
<html>
<head>
    <title>Cetak Label Barang TnJ 108</title>
    <style>
        @page { 
            margin: 0; 
        }
        body {
            margin:0;
            font-family: Arial, sans-serif;
            width: 210mm;
            height: 165mm;
            background-color: #edf4b7;
        }

        table {
            border-spacing: 3mm 2mm; 
            margin: auto;
            position: absolute;
        }

        td {
            width: 38mm;   
            height: 18mm;  
            border: 0.1pt solid #ccc; 
            vertical-align: middle;
            text-align: center;
            box-sizing: border-box;
            overflow: hidden;
            background-color: white;
            border-radius: 5px;
        }

        .empty-cell {
            border: 0.1pt solid #f2f2f2;
        }

        .nama {
            font-size: 8pt;
            font-weight: bold;
            text-transform: uppercase;
            line-height: 1.1;
            margin-bottom: 2px;
            word-wrap: break-word; 
        }

        .harga {
            font-size: 10pt;
            font-weight: bold;
            display: block;
        }

        .id {
            font-size: 6pt;
            color: #666;
            margin-top: 4px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
<table>
@for ($row = 1; $row <= 8; $row++)
<tr>
    @for ($col = 1; $col <= 5; $col++)
        @php
            $pos = (($row - 1) * 5) + $col;
        @endphp

            @if ($labels[$pos])
            <td>
                <div class="nama">{{ $labels[$pos]->nama }}</div>
                <div class="harga">Rp {{ number_format($labels[$pos]->harga, 0, ',', '.') }}</div>
                <div class="id">{{ $labels[$pos]->id_barang }}</div>
            </td>
            @else
                <td class="empty-cell">&nbsp;</td>
            @endif
    @endfor
</tr>
@endfor
</table>
</body>
</html>
