<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    private $archivo = 'productos.json';

    // Lee los productos desde el JSON (Con soporte para local y para el disco de Render)
    private function obtenerProductos()
    {
        // Si la carpeta /data existe (estamos en Render), guardamos ahí directamente con permisos de escritura.
        // Si no, usamos el storage normal (para cuando pruebes en local con XAMPP o Docker)
        $carpeta = is_dir('/data') ? '/data/' : storage_path('app/');
        $ruta = $carpeta . $this->archivo;

        // Si el archivo no existe en la ruta correspondiente, lo creamos vacío
        if (!file_exists($ruta)) {
            file_put_contents($ruta, '[]');
        }

        $data = file_get_contents($ruta);

        return json_decode($data, true) ?? [];
    }

    // Guarda los productos en el JSON (Con soporte para local y para el disco de Render)
    private function guardarProductos($productos)
    {
        $carpeta = is_dir('/data') ? '/data/' : storage_path('app/');
        $ruta = $carpeta . $this->archivo;

        file_put_contents($ruta, json_encode($productos, JSON_PRETTY_PRINT));
    }

    // Lista todos los productos en la vista principal
    public function index()
    {
        $productos = $this->obtenerProductos() ?? [];
        return view('productos', compact('productos'));
    }

    // Muestra el formulario de creación
    public function create()
    {
        return view('create');
    }

    // Guarda un nuevo producto enviado desde el formulario
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

    // Muestra el formulario de edición para un producto específico
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

    // Actualiza los datos de un producto editado
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

    // Elimina un producto por su código
    public function destroy($codigo)
    {
        $productos = $this->obtenerProductos() ?? [];

        $productos = array_filter($productos, function ($p) use ($codigo) {
            return $p['codigo'] != $codigo;
        });

        // array_values reindexa las posiciones del array para que el JSON quede limpio
        $this->guardarProductos(array_values($productos));

        return redirect()->route('productos.index');
    }

    // Retorna los datos como una API limpia en formato JSON
    public function api()
    {
        return response()->json($this->obtenerProductos());
    }
}