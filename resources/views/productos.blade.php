<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Productos</title>

<style>
body { font-family: Arial; background:#f4f7fc; padding:30px; }
.container { max-width:1000px; margin:auto; }
.card { background:white; padding:20px; border-radius:15px; }
table { width:100%; border-collapse:collapse; }
th, td { padding:12px; border-bottom:1px solid #ddd; text-align:center; }
.btn { padding:8px 12px; border-radius:8px; text-decoration:none; }
.edit { background:#f59e0b; color:white; }
.delete { background:#dc2626; color:white; border:none; cursor:pointer; }
.create { background:#2563eb; color:white; padding:10px 15px; display:inline-block; margin-bottom:15px; }
</style>
</head>

<body>
<div class="container">

<a href="{{ route('productos.create') }}" class="create">+ Nuevo Producto</a>

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
@foreach($productos as $p)
<tr>
<td>{{ $p['codigo'] }}</td>
<td>{{ $p['nombre'] }}</td>
<td>${{ $p['precio'] }}</td>
<td>{{ $p['cantidad'] }}</td>
<td>{{ $p['categoria'] }}</td>
<td>
<a class="btn edit" href="{{ route('productos.edit', $p['codigo']) }}">Editar</a>

<form action="{{ route('productos.destroy', $p['codigo']) }}" method="POST" style="display:inline;">
@csrf
@method('DELETE')
<button class="delete">Eliminar</button>
</form>
</td>
</tr>
@endforeach
</tbody>

</table>
</div>

</div>
</body>
</html>