<?php

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "vidasilvestre";

$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
$mensaje = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : '';
    $dni = isset($_POST["dni"]) ? $_POST["dni"] : '';
    $celular = isset($_POST["celular"]) ? $_POST["celular"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : '';
    $ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : '';
    $genero = isset($_POST["genero"]) ? $_POST["genero"] : '';
    $id_rol = isset($_POST["id_rol"]) ? $_POST["id_rol"] : '';
    $pais = isset($_POST["pais"]) ? $_POST["pais"] : '';
    $fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? $_POST["fecha_nacimiento"] : '';
    $fecha_ingreso = isset($_POST["fecha_ingreso"]) ? $_POST["fecha_ingreso"] : '';
    $contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : '';

    // Definir el valor predeterminado para el campo "estado" (asumiendo que se llama "estado")
    $estado = "Activo";
    $pais = "Argentina";
    
    $sql = "INSERT INTO persona (nombre, apellido, fecha_nacimiento, DNI, celular, email_correo, direccion, fecha_ingreso, pais, ciudad, contraseña, id_rol, genero, estado) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiiiiiiissss", $nombre, $apellido, $fecha_nacimiento, $dni, $celular ,$email, $direccion,$fecha_ingreso,$pais,$ciudad,$contrasena,$id_rol, $genero, $estado);
    
    if ($stmt->execute()) {
        $mensaje = "Alumno ingresado con éxito.";
        } else {
            $error = "Error al ingresar Alumno: " . $stmt->error;
        }
        
        $stmt->close();
    
        // Redirigir a la página "registrar_materia.php" con los mensajes en la URL
        header("Location: listadoalumnos.view.php?mensaje=" . urlencode($mensaje) . "&error=" . urlencode($error));
        exit();
    }
$conn->close();
?>