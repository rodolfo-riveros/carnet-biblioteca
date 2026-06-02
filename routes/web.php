<?php

use App\Livewire\Admin\Categoria\CategoriaForm;
use App\Livewire\Admin\Categoria\CategoriaIndex;
use App\Livewire\Admin\Institucion\InstitucionForm;
use App\Livewire\Admin\Institucion\InstitucionIndex;
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
});

require __DIR__.'/settings.php';
