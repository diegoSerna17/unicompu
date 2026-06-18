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
    font-family:Arial, sans-serif;
}

body{
    background:#f4f6f9;
    padding:40px;
}

.container{
    max-width:1200px;
    margin:auto;
}

h1{
    text-align:center;
    margin-bottom:30px;
}

.btn-crear{
    background:#16a34a;
    color:white;
    padding:12px 18px;
    text-decoration:none;
    border-radius:8px;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
    margin-top:20px;
}

th{
    background:#2563eb;
    color:white;
    padding:15px;
}

td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

.btn-editar{
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:8px 12px;
    border-radius:5px;
}

.btn-eliminar{
    background:#dc2626;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:5px;
    cursor:pointer;
}

.api{
    margin-top:20px;
}

.api a{
    background:#16a34a;
    color:white;
    text-decoration:none;
    padding:10px 20px;
    border-radius:8px;
}

</style>

</head>
<body>

<div class="container">

    <h1>Sistema de Productos - Unicomputo</h1>

    <a href="{{ route('productos.create') }}" class="btn-crear">
        Nuevo Producto
    </a>

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

        @foreach($productos as $producto)

            <tr>

                <td>{{ $producto->codigo }}</td>
                <td>{{ $producto->nombre }}</td>
                <td>${{ $producto->precio }}</td>
                <td>{{ $producto->cantidad }}</td>
                <td>{{ $producto->categoria }}</td>

                <td>

                    <a href="{{ route('productos.edit',$producto->codigo) }}"
                       class="btn-editar">
                        Editar
                    </a>

                    <form
                        action="{{ route('productos.destroy',$producto->codigo) }}"
                        method="POST"
                        style="display:inline;"
                    >
                        @csrf
                        @method('DELETE')

                        <button class="btn-eliminar">
                            Eliminar
                        </button>

                    </form>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

    <div class="api">

        <a href="/api/productos" target="_blank">
            Ver API JSON
        </a>

    </div>

</div>

</body>
</html>