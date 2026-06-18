<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Crear Producto</title>
</head>

<body>

<h2>Crear Producto</h2>

<form action="{{ route('productos.store') }}" method="POST">
@csrf

<input name="codigo" placeholder="Código"><br>
<input name="nombre" placeholder="Nombre"><br>
<input name="precio" placeholder="Precio"><br>
<input name="cantidad" placeholder="Cantidad"><br>
<input name="categoria" placeholder="Categoría"><br>

<button>Guardar</button>
</form>

<a href="{{ route('productos.index') }}">Volver</a>

</body>
</html>