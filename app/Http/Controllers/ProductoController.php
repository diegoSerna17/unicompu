<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    private $archivo = 'productos.json';

    private function obtenerProductos()
    {
        $ruta = storage_path('app/' . $this->archivo);

        if (!file_exists($ruta)) {
            file_put_contents($ruta, '[]');
        }

        $data = file_get_contents($ruta);

        return json_decode($data, true) ?? [];
    }

    private function guardarProductos($productos)
    {
        $ruta = storage_path('app/' . $this->archivo);

        file_put_contents($ruta, json_encode($productos, JSON_PRETTY_PRINT));
    }

    public function index()
    {
        $productos = $this->obtenerProductos() ?? [];
        return view('productos', compact('productos'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {
        $productos = $this->obtenerProductos() ?? [];

        $productos[] = [
            'codigo' => $request->codigo ?? '',
            'nombre' => $request->nombre ?? '',
            'precio' => $request->precio ?? 0,
            'cantidad' => $request->cantidad ?? 0,
            'categoria' => $request->categoria ?? '',
        ];

        $this->guardarProductos($productos);

        return redirect()->route('productos.index');
    }

    public function edit($codigo)
    {
        $productos = $this->obtenerProductos() ?? [];

        $producto = null;

        foreach ($productos as $p) {
            if ($p['codigo'] == $codigo) {
                $producto = $p;
                break;
            }
        }

        if (!$producto) {
            return redirect()->route('productos.index');
        }

        return view('edit', compact('producto'));
    }

    public function update(Request $request, $codigo)
    {
        $productos = $this->obtenerProductos() ?? [];

        foreach ($productos as &$producto) {
            if ($producto['codigo'] == $codigo) {
                $producto['nombre'] = $request->nombre ?? '';
                $producto['precio'] = $request->precio ?? 0;
                $producto['cantidad'] = $request->cantidad ?? 0;
                $producto['categoria'] = $request->categoria ?? '';
            }
        }

        $this->guardarProductos($productos);

        return redirect()->route('productos.index');
    }

    public function destroy($codigo)
    {
        $productos = $this->obtenerProductos() ?? [];

        $productos = array_filter($productos, function ($p) use ($codigo) {
            return $p['codigo'] != $codigo;
        });

        $this->guardarProductos(array_values($productos));

        return redirect()->route('productos.index');
    }

    public function api()
    {
        return response()->json($this->obtenerProductos());
    }
}