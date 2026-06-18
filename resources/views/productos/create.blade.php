<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Crear Producto</title>

<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6f9;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.form-container {
    background-color: #ffffff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    width: 100%;
    max-width: 400px;
}

h2 {
    text-align: center;
    margin-bottom: 24px;
    color: #333;
}

.form-group {
    margin-bottom: 16px;
}

label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
}

input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 8px;
}

button {
    width: 100%;
    background-color: #2563eb;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
}

button:hover {
    background-color: #1d4ed8;
}

.back-link {
    display: block;
    text-align: center;
    margin-top: 15px;
    color: #666;
    text-decoration: none;
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
            <input name="codigo" required>
        </div>

        <div class="form-group">
            <label>Nombre</label>
            <input name="nombre" required>
        </div>

        <div class="form-group">
            <label>Precio</label>
            <input name="precio" required>
        </div>

        <div class="form-group">
            <label>Cantidad</label>
            <input name="cantidad" required>
        </div>

        <div class="form-group">
            <label>Categoría</label>
            <input name="categoria" required>
        </div>

        <button type="submit">Guardar Producto</button>
    </form>

    <a href="{{ route('productos.index') }}" class="back-link">← Volver</a>
</div>

</body>
</html>