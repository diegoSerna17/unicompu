<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Obtiene la ruta del archivo JSON dependiendo del entorno.
     */
    private function getJsonPath()
    {
        // Si la carpeta /data existe (entorno de Render con disco persistente)
        if (is_dir('/data')) {
            return '/data/productos.json';
        }
        // Entorno local (tu PC)
        return storage_path('app/productos.json');
    }

    /**
     * Lee los productos desde el archivo JSON.
     */
    private function obtenerProductos()
    {
        $path = $this->getJsonPath();

        // Si el archivo no existe, lo crea con un array vacío []
        if (!file_exists($path)) {
            file_put_contents($path, json_encode([], JSON_PRETTY_PRINT));
            return [];
        }

        $json = file_get_contents($path);
        return json_decode($json, true) ?? [];
    }

    /**
     * Guarda la lista de productos en el archivo JSON.
     */
    private function guardarProductos($productos)
    {
        $path = $this->getJsonPath();
        
        // Nos aseguramos de que el directorio exista (útil en local)
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($path, json_encode(array_values($productos), JSON_PRETTY_PRINT));
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
     * Almacena un nuevo producto en el JSON.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $productos = $this->obtenerProductos();

        // Crear el nuevo producto con un ID único basado en el tiempo
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
     * Actualiza un producto existente en el JSON.
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
     * Elimina un producto del JSON.
     */
    public function destroy($id)
    {
        $productos = $this->obtenerProductos();
        
        // Filtramos para mantener todos los productos MENOS el que tenga el ID enviado
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