<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Conexión a la base de datos (reemplaza con tus credenciales)
$servername = "tu_servidor";
$username = "tu_usuario";
$password = "tu_contraseña";
$dbname = "tu_base_de_datos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nota1 = $_POST['nota1'];
$nota2 = $_POST['nota2'];

// Insertar los datos en la base de datos (adapta la consulta a tu estructura)
$sql = "INSERT INTO tu_tabla (nota1, nota2) VALUES ('$nota1', '$nota2')";

if ($conn->query($sql) === TRUE) {
    echo "Datos guardados correctamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Formulario con sincronización</title>
</head>
<body>
    <form action="guardar_datos.php" method="post">
        <label for="nota1">Nota 1:</label>
        <input type="text" id="nota1" name="nota1" value="hola">
        <br>
        <label for="nota2">Nota 2:</label>
        <input type="text" id="nota2" name="nota2" placeholder="Nota 2 (se sincroniza)">
        <br>
        <button type="submit">Guardar</button>
    </form>

    <script>
        // Seleccionamos los elementos por su ID
        const nota1 = document.getElementById('nota1');
        const nota2 = document.getElementById('nota2');

        // Escuchamos los cambios en el primer input
        nota1.addEventListener('input', () => {
            // Copiamos el valor al segundo input
            nota2.value = nota1.value;
        });
    </script>
</body>
</html>