<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    private function obtenerProductos()
    {
        $path = storage_path('app/productos.json');

        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }

        $productos = json_decode(file_get_contents($path), true);

        return is_array($productos) ? $productos : [];
    }

    private function guardarProductos($productos)
    {
        $path = storage_path('app/productos.json');

        file_put_contents(
            $path,
            json_encode(array_values($productos), JSON_PRETTY_PRINT)
        );
    }

    public function index()
    {
        $productos = $this->obtenerProductos();
        return view('productos', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad' => 'required|integer',
            'categoria' => 'required|string',
        ]);

        $productos = $this->obtenerProductos();

        $productos[] = [
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'categoria' => $request->categoria,
        ];

        $this->guardarProductos($productos);

        return redirect()->route('productos.index');
    }

    public function edit($codigo)
    {
        $productos = $this->obtenerProductos();

        $producto = collect($productos)
            ->firstWhere('codigo', $codigo);

        if (!$producto) {
            return redirect()->route('productos.index');
        }

        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, $codigo)
    {
        $productos = $this->obtenerProductos();

        foreach ($productos as &$p) {
            if (isset($p['codigo']) && $p['codigo'] == $codigo) {
                $p['nombre'] = $request->nombre;
                $p['precio'] = $request->precio;
                $p['cantidad'] = $request->cantidad;
                $p['categoria'] = $request->categoria;
            }
        }

        $this->guardarProductos($productos);

        return redirect()->route('productos.index');
    }

    public function destroy($codigo)
    {
        $productos = $this->obtenerProductos();

        $productos = array_filter($productos, function ($p) use ($codigo) {
            return isset($p['codigo']) && $p['codigo'] != $codigo;
        });

        $this->guardarProductos($productos);

        return redirect()->route('productos.index');
    }

    public function api()
    {
        return response()->json($this->obtenerProductos());
    }
}