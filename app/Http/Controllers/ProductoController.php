<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Obtiene la lista de productos guardada en la sesión.
     * Si no existe, la inicializa con los datos del archivo JSON original de storage.
     */
    private function obtenerProductos()
    {
        // Si ya existen productos en la sesión, los usamos
        if (session()->has('productos')) {
            return session('productos');
        }

        // Si es la primera vez, intentamos leer tu archivo JSON original de storage
        $path = storage_path('app/productos.json');
        if (file_exists($path)) {
            $json = file_get_contents($path);
            $productos = json_decode($json, true) ?? [];
            
            // Los guardamos en la sesión para el futuro
            session(['productos' => $productos]);
            return $productos;
        }

        return [];
    }

    /**
     * Guarda la lista de productos en la sesión del usuario (Gratis y sin errores de permisos).
     */
    private function guardarProductos($productos)
    {
        session(['productos' => array_values($productos)]);
    }

    /**
     * Muestra la vista principal con la lista de productos.
     */
    public function index()
    {
        $productos = $this->obtenerProductos();
        return view('productos.index', compact('productos'));
    }

    /**
     * Almacena un nuevo producto en la sesión.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $productos = $this->obtenerProductos();

        $nuevoProducto = [
            'id' => time(),
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion ?? '',
        ];

        $productos[] = $nuevoProducto;
        $this->guardarProductos($productos);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Actualiza un producto existente en la sesión.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $productos = $this->obtenerProductos();
        $encontrado = false;

        foreach ($productos as &$producto) {
            if ($producto['id'] == $id) {
                $producto['nombre'] = $request->nombre;
                $producto['precio'] = $request->precio;
                $producto['descripcion'] = $request->descripcion ?? '';
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            return redirect()->route('productos.index')->with('error', 'Producto no encontrado.');
        }

        $this->guardarProductos($productos);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Elimina un producto de la sesión.
     */
    public function destroy($id)
    {
        $productos = $this->obtenerProductos();
        
        $productosFiltrados = array_filter($productos, function ($producto) use ($id) {
            return $producto['id'] != $id;
        });

        if (count($productos) === count($productosFiltrados)) {
            return redirect()->route('productos.index')->with('error', 'Producto no encontrado.');
        }

        $this->guardarProductos($productosFiltrados);

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}