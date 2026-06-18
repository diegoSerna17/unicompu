<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Producto</title>
</head>

<body>

<h2>Editar Producto</h2>

<form action="{{ route('productos.update', $producto['codigo']) }}" method="POST">
@csrf
@method('PUT')

<input value="{{ $producto['codigo'] }}" disabled>

<input name="nombre" value="{{ $producto['nombre'] }}">
<input name="precio" value="{{ $producto['precio'] }}">
<input name="cantidad" value="{{ $producto['cantidad'] }}">
<input name="categoria" value="{{ $producto['categoria'] }}">

<button>Actualizar</button>
</form>

<a href="{{ route('productos.index') }}">Volver</a>

</body>
</html>