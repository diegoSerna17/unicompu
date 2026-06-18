<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Crear Producto</title>

<style>

body{
    background:#f4f7fc;
    font-family:Arial;
}

.card{
    width:500px;
    margin:50px auto;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:10px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    background:#16a34a;
    color:white;
    border-radius:10px;
    cursor:pointer;
}

a{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
}

</style>

</head>
<body>

<div class="card">

<h2>Crear Producto</h2>

<form action="{{ route('productos.store') }}" method="POST">
    @csrf

    <input type="text" name="codigo" placeholder="Código" required>

    <input type="text" name="nombre" placeholder="Nombre" required>

    <input type="number" name="precio" placeholder="Precio" required>

    <input type="number" name="cantidad" placeholder="Cantidad" required>

    <input type="text" name="categoria" placeholder="Categoría" required>

    <button type="submit">
        Guardar Producto
    </button>
</form>

<a href="{{ route('productos.index') }}">
Volver
</a>

</div>

</body>
</html>