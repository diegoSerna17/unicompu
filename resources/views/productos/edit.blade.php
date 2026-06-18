<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    
    <style>
        /* Estilos generales y fondo */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Tarjeta contenedora del formulario */
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 400px;
        }

        /* Título principal */
        h2 {
            text-align: center;
            color: #333333;
            margin-top: 0;
            margin-bottom: 24px;
            font-size: 24px;
        }

        /* Grupo de campos (Label + Input) */
        .form-group {
            margin-bottom: 16px;
        }

        /* Estilos de las etiquetas */
        label {
            display: block;
            margin-bottom: 6px;
            color: #555555;
            font-size: 14px;
            font-weight: 600;
        }

        /* Estilos de todos los inputs */
        input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #cccccc;
            border-radius: 8px;
            font-size: 15px;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        /* Efecto cuando el usuario hace clic en el input */
        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            outline: none;
        }

        /* Estilo especial para el input deshabilitado (Código) */
        input:disabled {
            background-color: #f3f4f6;
            color: #9ca3af;
            border-color: #e5e7eb;
            cursor: not-allowed;
        }

        /* Fila para poner Precio y Cantidad juntos */
        .form-row {
            display: flex;
            gap: 16px;
        }
        .form-row .form-group {
            flex: 1;
        }

        /* El botón de actualizar */
        button {
            width: 100%;
            background-color: #10b981; /* Color verde para diferenciar que es una edición */
            color: #ffffff;
            border: none;
            padding: 12px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 10px;
        }

        /* Efecto hover del botón */
        button:hover {
            background-color: #059669;
        }

        /* Enlace de volver */
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #666666;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #2563eb;
        }
    </style>
</head>

<body>

    <div class="form-container">
        <h2>Editar Producto</h2>

        <form action="{{ route('productos.update', $producto['id']) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Código (No editable)</label>
                <input value="{{ $producto['id'] }}" disabled>
            </div>

            <div class="form-group">
                <label>Nombre</label>
                <input name="nombre" required value="{{ $producto['nombre'] }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Precio</label>
                    <input name="precio" required value="{{ $producto['precio'] }}">
                </div>
                <div class="form-group">
                    <label>Cantidad</label>
                    <input name="cantidad" required value="{{ $producto['cantidad'] }}">
                </div>
            </div>

            <div class="form-group">
                <label>Categoría</label>
                <input name="categoria" required value="{{ $producto['categoria'] }}">
            </div>

            <button type="submit">Actualizar Producto</button>
        </form>

        <a href="{{ route('productos.index') }}" class="back-link">← Volver al listado</a>
    </div>

</body>
</html>