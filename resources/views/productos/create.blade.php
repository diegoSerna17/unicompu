<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Producto</title>

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
            background:green;
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

    <h2>➕ Crear Producto</h2>

    <form action="{{ route('productos.store') }}" method="POST">
        @csrf

        <input type="text" name="codigo" placeholder="Código" required>
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="number" name="precio" placeholder="Precio" required>
        <input type="number" name="cantidad" placeholder="Cantidad" required>
        <input type="text" name="categoria" placeholder="Categoría" required>

        <button type="submit">Guardar</button>
    </form>

    <a href="{{ route('productos.index') }}">← Volver</a>

</div>

</body>
</html>