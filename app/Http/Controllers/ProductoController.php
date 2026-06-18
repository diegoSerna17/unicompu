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

        return json_decode(file_get_contents($ruta), true);
    }

    private function guardarProductos($productos)
    {
        $ruta = storage_path('app/' . $this->archivo);

        file_put_contents($ruta, json_encode($productos, JSON_PRETTY_PRINT));
    }

    public function index()
    {
        $productos = $this->obtenerProductos();
        return view('productos', compact('productos'));
    }

    public function create()
    {
        return view('create');
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

        return redirect()->route('productos.index');
    }

    public function edit($codigo)
    {
        $productos = $this->obtenerProductos();

        $producto = collect($productos)
            ->firstWhere('codigo', $codigo);

        return view('edit', compact('producto'));
    }

    public function update(Request $request, $codigo)
    {
        $productos = $this->obtenerProductos();

        foreach ($productos as &$producto) {
            if ($producto['codigo'] == $codigo) {
                $producto['nombre'] = $request->nombre;
                $producto['precio'] = $request->precio;
                $producto['cantidad'] = $request->cantidad;
                $producto['categoria'] = $request->categoria;
            }
        }

        $this->guardarProductos($productos);

        return redirect()->route('productos.index');
    }

    public function destroy($codigo)
    {
        $productos = $this->obtenerProductos();

        $productos = array_filter(
            $productos,
            fn($p) => $p['codigo'] != $codigo
        );

        $this->guardarProductos(array_values($productos));

        return redirect()->route('productos.index');
    }

    public function api()
    {
        return response()->json($this->obtenerProductos());
    }
}