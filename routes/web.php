<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return redirect('/productos');
});

Route::resource('productos', ProductoController::class);