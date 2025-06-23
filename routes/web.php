<?php

use App\Models\Configuracion;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Models\Matricula;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/reporte/matricula/{id}/pdf', function ($id) {
    $matricula = Matricula::findOrFail($id);
    $configuracion = Configuracion::first();

    $pdf = Pdf::loadView('reporte.pdf.matricula', compact('matricula', 'configuracion'));

    return $pdf->download("matricula_{$matricula->id}.pdf");

    // return view('reporte.pdf.matricula', compact('matricula', 'configuracion'));

})->name('reporte.pdf.matricula');
