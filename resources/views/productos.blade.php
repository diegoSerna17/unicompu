<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Productos</title>

<style>
body { 
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
    background: #f4f6f9; 
    padding: 40px 20px; 
    margin: 0;
}

.container { max-width: 1000px; margin: auto; }

.header-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}

.create { 
    background: #2563eb; 
    color: white; 
    padding: 12px 20px; 
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

.btn-api {
    background: #7c3aed;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

.card { 
    background: white; 
    padding: 24px; 
    border-radius: 12px; 
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    overflow-x: auto; 
}

table { width: 100%; border-collapse: collapse; }

th { 
    background-color: #f8fafc;
    padding: 16px;
    border-bottom: 2px solid #e2e8f0;
    text-align: center;
}

td { 
    padding: 16px;
    border-bottom: 1px solid #e2e8f0;
    text-align: center;
}

.edit { background: #f59e0b; color: white; padding: 6px 10px; border-radius: 6px; text-decoration:none; }

.delete { background: #dc2626; color: white; border: none; padding: 6px 10px; border-radius: 6px; }
</style>
</head>

<body>

<div class="container">

<div class="header-actions">
    <a href="{{ route('productos.create') }}" class="create">+ Nuevo Producto</a>
    <a href="{{ route('productos.api') }}" class="btn-api" target="_blank">{} Ver API JSON</a>
</div>

<div class="card">

<table>
<thead>
<tr>
    <th>Código</th>
    <th>Nombre</th>
    <th>Precio</th>
    <th>Cantidad</th>
    <th>Categoría</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>

@forelse($productos as $p)
<tr>
    <td><strong>{{ $p['codigo'] ?? '' }}</strong></td>
    <td>{{ $p['nombre'] ?? '' }}</td>
    <td>${{ number_format($p['precio'] ?? 0, 2) }}</td>
    <td>{{ $p['cantidad'] ?? 0 }}</td>
    <td>{{ $p['categoria'] ?? '' }}</td>

    <td>
        <a class="edit" href="{{ route('productos.edit', $p['codigo'] ?? '') }}">Editar</a>

        <form action="{{ route('productos.destroy', $p['codigo'] ?? '') }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="delete">Eliminar</button>
        </form>
    </td>
</tr>
@empty
<tr>
    <td colspan="6">No hay productos registrados</td>
</tr>
@endforelse

</tbody>
</table>

</div>
</div>

</body>
</html>