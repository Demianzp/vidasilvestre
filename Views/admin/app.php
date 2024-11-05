<?php
// Variables para almacenar los valores
$valor1 = isset($_POST['valor1']) ? $_POST['valor1'] : '';
$valor2 = isset($_POST['valor2']) ? $_POST['valor2'] : '';

// Si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aquí puedes procesar los valores, por ejemplo guardarlos en base de datos
    // Por ahora solo los mostraremos
    echo "Valor 1 guardado: " . htmlspecialchars($valor1) . "<br>";
    echo "Valor 2 guardado: " . htmlspecialchars($valor2) . "<br>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sincronización de Inputs</title>
    <style>
        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Formulario con Inputs Sincronizados</h2>
    <form method="POST">
        <div class="form-group">
            <label>Input Principal:</label>
            <input type="text" 
                   name="valor1" 
                   value="<?php echo htmlspecialchars($valor1); ?>" 
                   oninput="sincronizarInput(this.value)">
        </div>
        
        <div class="form-group">
            <label>Input Sincronizado:</label>
            <input type="text" 
                   name="valor2" 
                   value="<?php echo htmlspecialchars($valor2); ?>" 
                   readonly>
        </div>

        <button type="submit">Guardar</button>
    </form>
</div>

<script>
function sincronizarInput(valor) {
    // Actualiza el valor del segundo input usando querySelector
    const input2 = document.querySelector('input[name="valor2"]');
    input2.value = valor;
}
</script>

</body>
</html>