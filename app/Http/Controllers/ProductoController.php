<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // =========================
    // LEER PRODUCTOS (JSON)
    // =========================
    private function obtenerProductos()
    {
        $path = storage_path('app/productos.json');

        // Crear archivo si no existe
        if (!file_exists($path)) {
            if (!file_exists(storage_path('app'))) {
                mkdir(storage_path('app'), 0777, true);
            }

            file_put_contents($path, json_encode([]));
        }

        $json = file_get_contents($path);
        $productos = json_decode($json, true);

        return is_array($productos) ? $productos : [];
    }

    // =========================
    // GUARDAR PRODUCTOS
    // =========================
    private function guardarProductos($productos)
    {
        $path = storage_path('app/productos.json');

        file_put_contents(
            $path,
            json_encode(array_values($productos), JSON_PRETTY_PRINT)
        );
    }

    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $productos = $this->obtenerProductos();

        return view('productos', compact('productos'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('productos.create');
    }

    // =========================
    // STORE (CREAR)
    // =========================
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

        // Evitar duplicados de código
        foreach ($productos as $p) {
            if ($p['codigo'] === $request->codigo) {
                return back()->with('error', 'El código ya existe');
            }
        }

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

    // =========================
    // EDIT
    // =========================
    public function edit($codigo)
    {
        $productos = $this->obtenerProductos();

        $producto = collect($productos)->firstWhere('codigo', $codigo);

        if (!$producto) {
            return redirect()->route('productos.index');
        }

        return view('productos.edit', compact('producto'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $codigo)
    {
        $productos = $this->obtenerProductos();

        foreach ($productos as &$p) {
            if ($p['codigo'] === $codigo) {
                $p['nombre'] = $request->nombre;
                $p['precio'] = $request->precio;
                $p['cantidad'] = $request->cantidad;
                $p['categoria'] = $request->categoria;
            }
        }

        $this->guardarProductos($productos);

        return redirect()->route('productos.index');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($codigo)
    {
        $productos = $this->obtenerProductos();

        $productos = array_filter($productos, function ($p) use ($codigo) {
            return $p['codigo'] !== $codigo;
        });

        $this->guardarProductos($productos);

        return redirect()->route('productos.index');
    }

    // =========================
    // API JSON
    // =========================
    public function api()
    {
        return response()->json($this->obtenerProductos());
    }
}