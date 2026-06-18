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
        if (session()->has('productos')) {
            return session('productos');
        }

        $path = storage_path('app/productos.json');
        if (file_exists($path)) {
            $json = file_get_contents($path);
            $productos = json_decode($json, true) ?? [];
            
            session(['productos' => $productos]);
            return $productos;
        }

        return [];
    }

    /**
     * Guarda la lista de productos en la sesión del usuario.
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
        return view('productos', compact('productos'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Almacena un nuevo producto en la sesión utilizando 'codigo'.
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo'    => 'required|string|max:255',
            'nombre'    => 'required|string|max:255',
            'precio'    => 'required|numeric|min:0',
            'cantidad'  => 'required|integer|min:0',
            'categoria' => 'required|string|max:255',
        ]);

        $productos = $this->obtenerProductos();

        // CORREGIDO: Ahora guardamos 'codigo' en vez de 'id', y sumamos cantidad y categoria
        $nuevoProducto = [
            'codigo'    => $request->codigo,
            'nombre'    => $request->nombre,
            'precio'    => $request->precio,
            'cantidad'  => $request->cantidad,
            'categoria' => $request->categoria,
        ];

        $productos[] = $nuevoProducto;
        $this->guardarProductos($productos);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un producto específico utilizando 'codigo'.
     */
    public function edit($codigo)
    {
        $productos = $this->obtenerProductos();
        $producto = null;

        foreach ($productos as $p) {
            // CORREGIDO: Buscamos usando la llave 'codigo'
            if (isset($p['codigo']) && $p['codigo'] == $codigo) {
                $producto = $p;
                break;
            }
        }

        if (!$producto) {
            return redirect()->route('productos.index')->with('error', 'Producto no encontrado.');
        }

        return view('productos.edit', compact('producto'));
    }

    /**
     * Actualiza un producto existente en la sesión mediante su 'codigo'.
     */
    public function update(Request $request, $codigo)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'precio'    => 'required|numeric|min:0',
            'cantidad'  => 'required|integer|min:0',
            'categoria' => 'required|string|max:255',
        ]);

        $productos = $this->obtenerProductos();
        $encontrado = false;

        foreach ($productos as &$producto) {
            // CORREGIDO: Buscamos y actualizamos usando la llave 'codigo'
            if (isset($producto['codigo']) && $producto['codigo'] == $codigo) {
                $producto['nombre']    = $request->nombre;
                $producto['precio']    = $request->precio;
                $producto['cantidad']  = $request->cantidad;
                $producto['categoria'] = $request->categoria;
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
     * Elimina un producto de la sesión usando 'codigo'.
     */
    public function destroy($codigo)
    {
        $productos = $this->obtenerProductos();
        
        // CORREGIDO: Filtramos comparando con la llave 'codigo'
        $productosFiltrados = array_filter($productos, function ($producto) use ($codigo) {
            return isset($producto['codigo']) ? $producto['codigo'] != $codigo : true;
        });

        if (count($productos) === count($productosFiltrados)) {
            return redirect()->route('productos.index')->with('error', 'Producto no encontrado.');
        }

        $this->guardarProductos($productosFiltrados);

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Endpoint API para responder en formato JSON
     */
    public function api()
    {
        return response()->json($this->obtenerProductos());
    }
}