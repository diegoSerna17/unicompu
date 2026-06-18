<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductoController extends Controller
{
    private $file = 'productos.json';

    private function getPath()
    {
        return storage_path('app/' . $this->file);
    }

    private function obtenerProductos()
    {
        $path = $this->getPath();

        if (!File::exists($path)) {
            File::ensureDirectoryExists(dirname($path));
            File::put($path, json_encode([]));
        }

        return json_decode(File::get($path), true) ?? [];
    }

    private function guardarProductos($productos)
    {
        $path = $this->getPath();

        File::ensureDirectoryExists(dirname($path));

        File::put($path, json_encode(array_values($productos), JSON_PRETTY_PRINT));
    }

    public function index()
    {
        return view('productos.index', [
            'productos' => $this->obtenerProductos()
        ]);
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $productos = $this->obtenerProductos();

        $productos[] = [
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'categoria' => $request->categoria,
        ];

        $this->guardarProductos($productos);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado correctamente');
    }

    public function edit($codigo)
    {
        $productos = $this->obtenerProductos();

        $producto = collect($productos)->firstWhere('codigo', $codigo);

        if (!$producto) {
            return redirect()->route('productos.index');
        }

        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $codigo)
    {
        $productos = $this->obtenerProductos();

        foreach ($productos as &$p) {
            if ($p['codigo'] == $codigo) {
                $p['nombre'] = $request->nombre;
                $p['precio'] = $request->precio;
                $p['cantidad'] = $request->cantidad;
                $p['categoria'] = $request->categoria;
            }
        }

        $this->guardarProductos($productos);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado');
    }

    public function destroy($codigo)
    {
        $productos = $this->obtenerProductos();

        $productos = array_values(array_filter(
            $productos,
            fn($p) => $p['codigo'] != $codigo
        ));

        $this->guardarProductos($productos);

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado');
    }

    public function api()
    {
        return response()->json($this->obtenerProductos());
    }
}