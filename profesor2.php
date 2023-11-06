<!--------------------------->
<?php
require 'conn/connection.php';
session_start();

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
    $stmt = $db->prepare($sql);
    
    if ($stmt) {
        $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(2, $apellido, PDO::PARAM_STR);
        $stmt->bindParam(3, $fecha_nacimiento, PDO::PARAM_STR);
        $stmt->bindParam(4, $dni, PDO::PARAM_STR);
        $stmt->bindParam(5, $celular, PDO::PARAM_STR);
        $stmt->bindParam(6, $email, PDO::PARAM_STR);
        $stmt->bindParam(7, $direccion, PDO::PARAM_STR);
        $stmt->bindParam(8, $fecha_ingreso, PDO::PARAM_STR);
        $stmt->bindParam(9, $pais, PDO::PARAM_STR);
        $stmt->bindParam(10, $ciudad, PDO::PARAM_STR);
        $stmt->bindParam(11, $contrasena, PDO::PARAM_STR);
        $stmt->bindParam(12, $id_rol, PDO::PARAM_STR);
        $stmt->bindParam(13, $genero, PDO::PARAM_STR);
        $stmt->bindParam(14, $estado, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Mensaje de éxito
            $_SESSION['message'] = "Los datos se han cargado con éxito.";
            header('Location: profesor.php'); // Redirige a profesor.php
        } else {
            // Mensaje de error
            $_SESSION['message'] = "Error al cargar los datos.";
            header('Location: profesor.php'); // Redirige a profesor.php
        }
             

}

}