<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>

    <style>
        body{
            font-family: Arial;
            background:#f3f4f6;
            padding:30px;
        }

        .container{
            max-width:900px;
            margin:auto;
            background:white;
            padding:20px;
            border-radius:10px;
        }

        .top{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:10px;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:20px;
        }

        th, td{
            border:1px solid #ddd;
            padding:10px;
        }

        th{
            background:#2563eb;
            color:white;
        }

        tr:hover{
            background:#f1f5f9;
        }

        .btn{
            padding:8px 12px;
            border-radius:6px;
            text-decoration:none;
            color:white;
            font-size:14px;
            border:none;
            cursor:pointer;
        }

        .btn-create{ background:green; }
        .btn-edit{ background:orange; }
        .btn-delete{ background:red; }

        .alert{
            background:#d1fae5;
            color:#065f46;
            padding:10px;
            border-radius:8px;
            margin-bottom:10px;
        }
        .btn-json{
    background:#111827;
}
    </style>
</head>
<body>

<div class="container">

    <div class="top">
        <h2>📦 Lista de Productos</h2>

        <a href="{{ route('productos.json') }}" target="_blank" class="btn btn-json">
    📄 Ver JSON
</a>

        <a href="{{ route('productos.create') }}" class="btn btn-create">
            ➕ Crear Producto
        </a>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

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
                    <td>{{ $p['codigo'] }}</td>
                    <td>{{ $p['nombre'] }}</td>
                    <td>{{ $p['precio'] }}</td>
                    <td>{{ $p['cantidad'] }}</td>
                    <td>{{ $p['categoria'] }}</td>
                    <td>
                        <a href="{{ route('productos.edit', $p['codigo']) }}" class="btn btn-edit">Editar</a>

                        <form action="{{ route('productos.destroy', $p['codigo']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete" onclick="return confirm('¿Eliminar producto?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay productos</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

</body>
</html>