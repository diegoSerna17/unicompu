<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f4f6f9;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .card{
            width:500px;
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0 5px 15px rgba(0,0,0,.1);
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
            border-radius:8px;
        }

        button{
            width:100%;
            padding:12px;
            background:#2563eb;
            color:white;
            border:none;
            border-radius:8px;
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

    <h2>Editar Producto</h2>

    <form action="{{ route('productos.update', $producto->codigo) }}" method="POST">

        @csrf
        @method('PUT')

        <input type="text"
               name="codigo"
               value="{{ $producto->codigo }}"
               readonly>

        <input type="text"
               name="nombre"
               value="{{ $producto->nombre }}"
               required>

        <input type="number"
               step="0.01"
               name="precio"
               value="{{ $producto->precio }}"
               required>

        <input type="number"
               name="cantidad"
               value="{{ $producto->cantidad }}"
               required>

        <input type="text"
               name="categoria"
               value="{{ $producto->categoria }}"
               required>

        <button type="submit">
            Actualizar Producto
        </button>

    </form>

    <a href="{{ route('productos.index') }}">
        Volver
    </a>

</div>

</body>
</html>