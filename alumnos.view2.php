<?php
// Incluye el archivo de conexión
include 'conn/connection.php';
$mensaje = "";
$error = "";
// Verifica si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los valores del formulario
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
    $pais="Argentina";
    try {
        $sql = "INSERT INTO persona (nombre, apellido, fecha_nacimiento, DNI, celular, email_correo, direccion, fecha_ingreso, pais, ciudad, contraseña, id_rol, genero, estado) 
        VALUES (:nombre, :apellido, :fecha_nacimiento, :dni, :celular, :email, :direccion, :fecha_ingreso, :pais, :ciudad, :contrasena, :id_rol, :genero, :estado)";
        
        $stmt = $db->prepare($sql);
        // Vincular los parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':celular', $celular);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
        $stmt->bindParam(':pais', $pais);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->bindParam(':id_rol', $id_rol);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':estado', $estado);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = "Persona ingresada con éxito.";
        } else {
            $error = "Error al ingresar Persona: " . $stmt->errorInfo()[2];
        }

    } catch (PDOException $e) {
        $error = "Error en la consulta: " . $e->getMessage();
    }
}
// Redirigir a la página "listadoalumnos.view.php" con los mensajes en la URL
header("Location: listadoalumnos.view.php?mensaje=" . urlencode($mensaje) . "&error=" . urlencode($error));
exit();?>
