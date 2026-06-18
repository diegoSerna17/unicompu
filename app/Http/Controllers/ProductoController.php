<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    private $file = 'public/productos.json';

    // =========================
    // LEER PRODUCTOS
    // =========================
    private function obtenerProductos()
    {
        if (!Storage::exists($this->file)) {
            Storage::put($this->file, json_encode([]));
        }

        $json = Storage::get($this->file);
        $productos = json_decode($json, true);

        return is_array($productos) ? $productos : [];
    }

    // =========================
    // GUARDAR PRODUCTOS
    // =========================
    private function guardarProductos($productos)
    {
        Storage::put(
            $this->file,
            json_encode(array_values($productos), JSON_PRETTY_PRINT)
        );
    }

    // =========================
    // INDEX
    // =========================
    public function index()
    {
        return view('productos', [
            'productos' => $this->obtenerProductos()
        ]);
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('productos.create');
    }

    // =========================
    // STORE
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
    // API
    // =========================
    public function api()
    {
        return response()->json($this->obtenerProductos());
    }
}