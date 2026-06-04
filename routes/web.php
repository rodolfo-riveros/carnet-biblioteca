<?php

use App\Http\Controllers\CarnetPdfController;
use App\Livewire\Admin\Carnet\CarnetImpresion;
use App\Livewire\Admin\Categoria\CategoriaForm;
use App\Livewire\Admin\Categoria\CategoriaIndex;
use App\Livewire\Admin\Estudiante\EstudianteForm;
use App\Livewire\Admin\Estudiante\EstudianteIndex;
use App\Livewire\Admin\Institucion\InstitucionForm;
use App\Livewire\Admin\Institucion\InstitucionIndex;
use App\Livewire\Admin\ProgramaEstudio\ProgramaEstudioForm;
use App\Livewire\Admin\ProgramaEstudio\ProgramaEstudioIndex;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::prefix('instituciones')->name('instituciones.')->group(function () {
        Route::get('/', InstitucionIndex::class)->name('index');
        Route::get('/create', InstitucionForm::class)->name('create');
        Route::get('/edit/{id}', InstitucionForm::class)->name('edit');
    });

    Route::prefix('categorias')->name('categorias.')->group(function () {
        Route::get('/', CategoriaIndex::class)->name('index');
        Route::get('/create', CategoriaForm::class)->name('create');
        Route::get('/edit/{id}', CategoriaForm::class)->name('edit');
    });

    Route::prefix('programa-estudios')->name('programa-estudios.')->group(function () {
        Route::get('/', ProgramaEstudioIndex::class)->name('index');
        Route::get('/create', ProgramaEstudioForm::class)->name('create');
        Route::get('/edit/{id}', ProgramaEstudioForm::class)->name('edit');
    });

    Route::prefix('estudiantes')->name('estudiantes.')->group(function () {
        Route::get('/', EstudianteIndex::class)->name('index');
        Route::get('/create', EstudianteForm::class)->name('create');
        Route::get('/edit/{id}', EstudianteForm::class)->name('edit');
    });

    Route::prefix('carnets')->name('carnets.')->group(function () {
        Route::get('/imprimir', CarnetImpresion::class)->name('imprimir');
        Route::get('/pdf/{estudiante}', [CarnetPdfController::class, 'download'])->name('pdf');
        Route::get('/pdf-stream/{estudiante}', [CarnetPdfController::class, 'stream'])->name('pdf.stream');
        Route::get('/pdf-masivo', [CarnetPdfController::class, 'downloadMasivo'])->name('pdf.masivo');
        Route::get('/pdf-stream-masivo', [CarnetPdfController::class, 'streamMasivo'])->name('pdf.stream-masivo');
    });
});

require __DIR__.'/settings.php';
