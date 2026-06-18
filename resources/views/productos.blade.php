<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Productos Unicomputo</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Arial, Helvetica, sans-serif;
}

body{
    background:#f4f7fc;
    padding:40px;
}

.container{
    max-width:1200px;
    margin:auto;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

h1{
    color:#1e293b;
}

.btn{
    text-decoration:none;
    background:#2563eb;
    color:white;
    padding:12px 20px;
    border-radius:10px;
}

.card{
    background:white;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#2563eb;
    color:white;
}

th,td{
    padding:15px;
    text-align:center;
}

tr:nth-child(even){
    background:#f8fafc;
}

.precio{
    color:#16a34a;
    font-weight:bold;
}

.badge{
    background:#dbeafe;
    color:#1d4ed8;
    padding:6px 12px;
    border-radius:20px;
}

.btn-editar{
    background:#f59e0b;
    color:white;
    text-decoration:none;
    padding:8px 12px;
    border-radius:8px;
}

.btn-eliminar{
    background:#dc2626;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
}

.api{
    text-align:center;
    margin-top:25px;
}

.api a{
    text-decoration:none;
    background:#16a34a;
    color:white;
    padding:12px 20px;
    border-radius:10px;
}

</style>

</head>
<body>

<div class="container">

<div class="header">
    <h1>Sistema de Productos - Unicomputo</h1>

    <a href="{{ route('productos.create') }}" class="btn">
        Nuevo Producto
    </a>
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

@if(!empty($productos))

@foreach($productos as $producto)

<tr>

<td>{{ $producto['codigo'] }}</td>
<td>{{ $producto['nombre'] }}</td>
<td class="precio">$ {{ number_format($producto['precio']) }}</td>
<td>{{ $producto['cantidad'] }}</td>

<td>
<span class="badge">
{{ $producto['categoria'] }}
</span>
</td>

<td>

<a href="{{ route('productos.edit',$producto['codigo']) }}"
class="btn-editar">
Editar
</a>

<form action="{{ route('productos.destroy',$producto['codigo']) }}"
method="POST"
style="display:inline;">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn-eliminar"
    onclick="return confirm('¿Eliminar producto?')">
        Eliminar
    </button>
</form>

</td>

</tr>

@endforeach

@else

<tr>
    <td colspan="6">No hay productos registrados</td>
</tr>

@endif

</tbody>

</table>

</div>

<div class="api">
    <a href="/api/productos" target="_blank">
        Ver API JSON
    </a>
</div>

</div>

</body>
</html>