<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

// Esta es tu vista HTML principal con la tabla de productos
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');

// Esta es tu ruta por si necesitas consumir los datos en JSON desde otra parte
Route::get('/api/productos', [ProductoController::class, 'api'])->name('productos.api');