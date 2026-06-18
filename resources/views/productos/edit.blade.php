<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>

    <style>
        body{
            font-family: Arial;
            background:#f3f4f6;
            padding:30px;
        }

        .container{
            max-width:500px;
            margin:auto;
            background:white;
            padding:20px;
            border-radius:10px;
        }

        input{
            width:100%;
            padding:10px;
            margin:8px 0;
            border:1px solid #ddd;
            border-radius:6px;
        }

        button{
            width:100%;
            padding:10px;
            background:orange;
            color:white;
            border:none;
            border-radius:6px;
            cursor:pointer;
        }

        a{
            display:block;
            margin-top:10px;
            text-align:center;
            color:#2563eb;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>✏️ Editar Producto</h2>

    <form action="{{ route('productos.update', $producto['codigo']) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="text" name="nombre" value="{{ $producto['nombre'] }}" required>
        <input type="number" name="precio" value="{{ $producto['precio'] }}" required>
        <input type="number" name="cantidad" value="{{ $producto['cantidad'] }}" required>
        <input type="text" name="categoria" value="{{ $producto['categoria'] }}" required>

        <button type="submit">Actualizar</button>
    </form>

    <a href="{{ route('productos.index') }}">← Volver</a>

</div>

</body>
</html>