<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    
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
            box-sizing: border-box; /* Evita que el padding deforme el ancho */
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        /* Efecto cuando el usuario hace clic en el input */
        input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
        }

        /* Fila para poner Precio y Cantidad juntos */
        .form-row {
            display: flex;
            gap: 16px;
        }
        .form-row .form-group {
            flex: 1;
        }

        /* El botón de guardar */
        button {
            width: 100%;
            background-color: #2563eb;
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
            background-color: #1d4ed8;
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
        <h2>Crear Producto</h2>

        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Código</label>
                <input name="codigo" placeholder="Ej: PROD-100">
            </div>

            <div class="form-group">
                <label>Nombre</label>
                <input name="nombre" placeholder="Nombre del producto">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Precio</label>
                    <input name="precio" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label>Cantidad</label>
                    <input name="cantidad" placeholder="Cantidad">
                </div>
            </div>

            <div class="form-group">
                <label>Categoría</label>
                <input name="categoria" placeholder="Categoría del producto">
            </div>

            <button type="submit">Guardar Producto</button>
        </form>

        <a href="{{ route('productos.index') }}" class="back-link">← Volver al listado</a>
    </div>

</body>
</html>