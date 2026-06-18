<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', [ProductoController::class, 'index']);

// Cambiado el nombre de productos.index a solo 'productos'
Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
Route::get('/productos/create', [ProductoController::class, 'create'])->name('productos.create');

// Cambiado el nombre de productos.store a solo 'productos' (funciona porque es método POST)
Route::post('/productos', [ProductoController::class, 'store'])->name('productos');

Route::get('/productos/{codigo}/edit', [ProductoController::class, 'edit'])->name('productos.edit');
Route::put('/productos/{codigo}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{codigo}', [ProductoController::class, 'destroy'])->name('productos.destroy');

Route::get('/api/productos', [ProductoController::class, 'api'])->name('productos.api');