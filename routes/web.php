<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', [ProductoController::class, 'index']);

Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

Route::get('/productos/{codigo}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
Route::put('/productos/{codigo}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{codigo}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::get('/api/productos', [ProductoController::class, 'api']);