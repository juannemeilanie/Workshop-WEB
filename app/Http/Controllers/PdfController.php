<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function sertifikat()
    {
        $pdf = Pdf::loadView('pdf.sertifikat')
            ->setPaper('A4', 'landscape');

        return $pdf->stream('sertifikat.pdf');
    }

    public function undangan()
    {
        $pdf = Pdf::loadView('pdf.undangan')
            ->setPaper('A4', 'portrait');

        return $pdf->stream('undangan.pdf');
    }
}
