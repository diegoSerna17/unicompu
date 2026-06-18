<?php

use Illuminate\Support\Facades\Route;
use App\Models\Producto;

Route::get('/productos', function () {
    return Producto::all();
});