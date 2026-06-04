<?php

use App\Http\Controllers\CarnetPdfController;
use App\Livewire\Admin\Carnet\CarnetImpresion;
use App\Livewire\Admin\Categoria\CategoriaForm;
use App\Livewire\Admin\Categoria\CategoriaIndex;
use App\Livewire\Admin\Estudiante\EstudianteForm;
use App\Livewire\Admin\Estudiante\EstudianteIndex;
use App\Livewire\Admin\Institucion\InstitucionForm;
use App\Livewire\Admin\Institucion\InstitucionIndex;
use App\Livewire\Admin\Libro\LibroForm;
use App\Livewire\Admin\Libro\LibroIndex;
use App\Livewire\Admin\Prestamo\PrestamoForm;
use App\Livewire\Admin\Prestamo\PrestamoIndex;
use App\Livewire\Admin\ProgramaEstudio\ProgramaEstudioForm;
use App\Livewire\Admin\ProgramaEstudio\ProgramaEstudioIndex;
use App\Livewire\Admin\Role\RoleForm;
use App\Livewire\Admin\Role\RoleIndex;
use App\Livewire\Admin\User\UserForm;
use App\Livewire\Admin\User\UserIndex;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::prefix('instituciones')->name('instituciones.')->middleware('can:ver instituciones')->group(function () {
        Route::get('/', InstitucionIndex::class)->name('index');
        Route::get('/create', InstitucionForm::class)->middleware('can:crear instituciones')->name('create');
        Route::get('/edit/{id}', InstitucionForm::class)->middleware('can:editar instituciones')->name('edit');
    });

    Route::prefix('categorias')->name('categorias.')->middleware('can:ver categorias')->group(function () {
        Route::get('/', CategoriaIndex::class)->name('index');
        Route::get('/create', CategoriaForm::class)->middleware('can:crear categorias')->name('create');
        Route::get('/edit/{id}', CategoriaForm::class)->middleware('can:editar categorias')->name('edit');
    });

    Route::prefix('programa-estudios')->name('programa-estudios.')->middleware('can:ver programas')->group(function () {
        Route::get('/', ProgramaEstudioIndex::class)->name('index');
        Route::get('/create', ProgramaEstudioForm::class)->middleware('can:crear programas')->name('create');
        Route::get('/edit/{id}', ProgramaEstudioForm::class)->middleware('can:editar programas')->name('edit');
    });

    Route::prefix('estudiantes')->name('estudiantes.')->middleware('can:ver estudiantes')->group(function () {
        Route::get('/', EstudianteIndex::class)->name('index');
        Route::get('/create', EstudianteForm::class)->middleware('can:crear estudiantes')->name('create');
        Route::get('/edit/{id}', EstudianteForm::class)->middleware('can:editar estudiantes')->name('edit');
    });

    Route::prefix('libros')->name('libros.')->middleware('can:ver libros')->group(function () {
        Route::get('/', LibroIndex::class)->name('index');
        Route::get('/create', LibroForm::class)->middleware('can:crear libros')->name('create');
        Route::get('/edit/{id}', LibroForm::class)->middleware('can:editar libros')->name('edit');
    });

    Route::prefix('prestamos')->name('prestamos.')->middleware('can:ver prestamos')->group(function () {
        Route::get('/', PrestamoIndex::class)->name('index');
        Route::get('/create', PrestamoForm::class)->middleware('can:crear prestamos')->name('create');
        Route::get('/edit/{id}', PrestamoForm::class)->middleware('can:editar prestamos')->name('edit');
    });

    Route::prefix('usuarios')->name('usuarios.')->middleware('can:ver usuarios')->group(function () {
        Route::get('/', UserIndex::class)->name('index');
        Route::get('/create', UserForm::class)->middleware('can:crear usuarios')->name('create');
        Route::get('/edit/{id}', UserForm::class)->middleware('can:editar usuarios')->name('edit');
    });

    Route::prefix('roles')->name('roles.')->middleware('can:ver roles')->group(function () {
        Route::get('/', RoleIndex::class)->name('index');
        Route::get('/create', RoleForm::class)->middleware('can:crear roles')->name('create');
        Route::get('/edit/{id}', RoleForm::class)->middleware('can:editar roles')->name('edit');
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
