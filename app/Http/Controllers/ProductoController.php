<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|unique:productos,codigo',
            'nombre' => 'required',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'categoria' => 'required'
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function edit($codigo)
    {
        $producto = Producto::findOrFail($codigo);

        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $codigo)
    {
        $producto = Producto::findOrFail($codigo);

        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'categoria' => $request->categoria
        ]);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado correctamente');
    }

    public function destroy($codigo)
    {
        Producto::destroy($codigo);

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado correctamente');
    }
}