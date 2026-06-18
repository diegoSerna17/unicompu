<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Producto</title>

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
    background: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    width: 100%;
    max-width: 400px;
}

h2 {
    text-align: center;
    margin-bottom: 24px;
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

input:disabled {
    background: #f3f4f6;
}

button {
    width: 100%;
    background-color: #10b981;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 8px;
    cursor: pointer;
}

button:hover {
    background-color: #059669;
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
    <h2>Editar Producto</h2>

    <form action="{{ route('productos.update', $producto['codigo'] ?? '') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Código (no editable)</label>
            <input value="{{ $producto['codigo'] ?? '' }}" disabled>
        </div>

        <div class="form-group">
            <label>Nombre</label>
            <input name="nombre" value="{{ $producto['nombre'] ?? '' }}" required>
        </div>

        <div class="form-group">
            <label>Precio</label>
            <input name="precio" value="{{ $producto['precio'] ?? '' }}" required>
        </div>

        <div class="form-group">
            <label>Cantidad</label>
            <input name="cantidad" value="{{ $producto['cantidad'] ?? '' }}" required>
        </div>

        <div class="form-group">
            <label>Categoría</label>
            <input name="categoria" value="{{ $producto['categoria'] ?? '' }}" required>
        </div>

        <button type="submit">Actualizar</button>
    </form>

    <a href="{{ route('productos.index') }}" class="back-link">← Volver</a>
</div>

</body>
</html>