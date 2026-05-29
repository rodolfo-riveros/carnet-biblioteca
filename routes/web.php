<?php

use App\Livewire\Admin\Institucion\InstitucionForm;
use App\Livewire\Admin\Institucion\InstitucionTable;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::prefix('instituciones')->name('instituciones.')->group(function () {
        Route::get('/', InstitucionTable::class)->name('index');
        Route::get('/create', InstitucionForm::class)->name('create');
        Route::get('/edit/{id}', InstitucionForm::class)->name('edit');
    });
});

require __DIR__ . '/settings.php';
