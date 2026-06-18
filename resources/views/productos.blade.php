<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>

    <style>
        /* Estilos generales y fondo */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #f4f6f9; 
            padding: 40px 20px; 
            margin: 0;
        }
        
        .container { 
            max-width: 1000px; 
            margin: auto; 
        }

        /* Contenedor para los botones de arriba */
        .header-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        /* Botón de Crear Nuevo Producto */
        .create { 
            background: #2563eb; 
            color: white; 
            padding: 12px 20px; 
            display: inline-block; 
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.15);
            transition: background 0.2s, transform 0.1s;
        }
        .create:hover {
            background: #1d4ed8;
        }
        .create:active {
            transform: scale(0.98);
        }

        /* NUEVO: Botón para ir a la API JSON (Morado) */
        .btn-api {
            background: #7c3aed;
            color: white;
            padding: 12px 20px;
            display: inline-block;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 4px 6px rgba(124, 58, 237, 0.15);
            transition: background 0.2s, transform 0.1s;
        }
        .btn-api:hover {
            background: #6d28d9;
        }
        .btn-api:active {
            transform: scale(0.98);
        }

        /* Tarjeta blanca contenedora de la tabla */
        .card { 
            background: white; 
            padding: 24px; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow-x: auto; 
        }

        /* Estilos de la Tabla */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            text-align: left;
        }

        th { 
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            padding: 16px 12px; 
            border-bottom: 2px solid #e2e8f0; 
            text-align: center;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td { 
            padding: 16px 12px; 
            border-bottom: 1px solid #e2e8f0; 
            text-align: center; 
            color: #334155;
            font-size: 15px;
        }

        tbody tr:hover {
            background-color: #f8fafc;
        }

        .badge {
            background-color: #e2e8f0;
            color: #475569;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }

        .btn { 
            padding: 8px 16px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            transition: background 0.2s;
        }

        .edit { 
            background: #f59e0b; 
            color: white; 
            margin-right: 4px;
        }
        .edit:hover {
            background: #d97706;
        }

        .delete { 
            background: #dc2626; 
            color: white; 
            border: none; 
            padding: 8px 16px; 
            border-radius: 6px; 
            font-size: 14px;
            font-weight: 600;
            cursor: pointer; 
            transition: background 0.2s;
        }
        .delete:hover {
            background: #b91c1c;
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header-actions">
        <a href="{{ route('productos.create') }}" class="create">+ Nuevo Producto</a>
        <a href="{{ route('productos.api') }}" class="btn-api" target="_blank">{} Ver API JSON</a>
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
                @foreach($productos as $p)
                <tr>
                    <td><strong>{{ $p['codigo'] }}</strong></td>
                    <td>{{ $p['nombre'] }}</td>
                    <td style="color: #16a34a; font-weight: 600;">${{ number_format($p['precio'], 2) }}</td>
                    <td>{{ $p['cantidad'] }} u.</td>
                    <td><span class="badge">{{ $p['categoria'] }}</span></td>
                    <td>
                        <a class="btn edit" href="{{ route('productos.edit', $p['codigo']) }}">Editar</a>

                        <form action="{{ route('productos.destroy', $p['codigo']) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete">Eliminar</button>
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