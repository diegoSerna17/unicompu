<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    private $file = 'productos.json';

    // =========================
    // PATH (IMPORTANTE RENDER SAFE)
    // =========================
    private function getPath()
    {
        return sys_get_temp_dir() . '/' . $this->file;
    }

    // =========================
    // LEER (JSON → ARRAY)
    // =========================
    private function obtenerProductos()
    {
        $path = $this->getPath();

        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }

        $json = file_get_contents($path);

        $array = json_decode($json, true);

        return is_array($array) ? $array : [];
    }

    // =========================
    // GUARDAR (ARRAY → JSON)
    // =========================
    private function guardarProductos($productos)
    {
        $path = $this->getPath();

        file_put_contents($path, json_encode($productos, JSON_PRETTY_PRINT));
    }

    // =========================
    // INDEX
    // =========================
    public function index()
    {
        $productos = $this->obtenerProductos();

        return view('productos.index', compact('productos'));
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
        $productos = $this->obtenerProductos(); // ARRAY

        $productos[] = [
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'cantidad' => $request->cantidad,
            'categoria' => $request->categoria,
        ];

        $this->guardarProductos($productos);

        return redirect('/productos')->with('success', 'Producto creado');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($codigo)
    {
        $productos = $this->obtenerProductos();

        foreach ($productos as $p) {
            if ($p['codigo'] == $codigo) {
                return view('productos.edit', ['producto' => $p]);
            }
        }

        return redirect('/productos');
    }

    // =========================
    // UPDATE
    // =========================
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

        return redirect('/productos')->with('success', 'Actualizado');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($codigo)
    {
        $productos = $this->obtenerProductos();

        $productos = array_values(array_filter(
            $productos,
            fn($p) => $p['codigo'] != $codigo
        ));

        $this->guardarProductos($productos);

        return redirect('/productos')->with('success', 'Eliminado');
    }

    // =========================
    // JSON VIEW
    // =========================
    public function json()
    {
        return response()->json($this->obtenerProductos());
    }


    public function api()
{
    return response()->json($this->obtenerProductos());
}
}

