<?php
require 'conn/connection.php';
// Variables para mensajes
$mensaje = "";
$error = "";

try {
    // Procesar el formulario cuando se envíe
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $nombre = $conn->quote($_POST["nombre"]);
        $descripcion = $conn->quote($_POST["descripcion"]);
        $horas = (int)$_POST["horas"];
        $año = (int)$_POST["año"];
        $num_resolucion = (int)$_POST["num_resolucion"];
        $plan_estudio = $conn->quote($_POST["plan_estudio"]);
        $tipo = $conn->quote($_POST["tipo"]);
        $estado = 'Activo'; // Valor predeterminado para el estado ,  estado es si esta activo o inactivo.

        // Inserción de datos en la tabla 'materia' (usando sentencia preparada)
        $sql = "INSERT INTO materia (nombre, descripcion, horas, año, num_resolucion, plan_estudio, tipo, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $descripcion);
        $stmt->bindParam(3, $horas, PDO::PARAM_INT);
        $stmt->bindParam(4, $año, PDO::PARAM_INT);
        $stmt->bindParam(5, $num_resolucion, PDO::PARAM_INT);
        $stmt->bindParam(6, $plan_estudio);
        $stmt->bindParam(7, $tipo);
        $stmt->bindParam(8, $estado);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            $mensaje = "Materia ingresada con éxito.";
        } else {
            $error = "Error al ingresar Materia: " . $stmt->errorInfo()[2];
        }

        // Cerrar la conexión y la declaración preparada
        $stmt->closeCursor();
        $conn = null;
    }
} catch (PDOException $e) {
    $error = "Error en la conexión o consulta: " . $e->getMessage();
}

// Redirigir a la página "listado_materia.php" con los mensajes en la URL
header("Location: listado_materia.php?mensaje=" . urlencode($mensaje) . "&error=" . urlencode($error));
exit();?>