<?php
// Incluye el archivo de conexión
require 'conn/connection.php';

// Recopila los datos del formulario
$id_materia = $_POST['materia'];
$nombre_mesa = isset($_POST['nombre_mesa']) ? $_POST['nombre_mesa'] : '';
$fecha = $_POST['fecha'];
$fecha_fin = $_POST['fecha_fin'];
$hora = $_POST['hora'];
$id_tipo = $_POST['id_tipo'];
$ciclo_lectivo = $_POST['ciclo_lectivo'];
$estado = "Activo";

// Verifica que el campo 'nombre_mesa' no sea nulo
if (empty($nombre_mesa)) {
    echo "Error: El campo 'nombre_mesa' no puede estar vacío.";
    exit; // Sale del script si hay un error
}

// Inserta la mesa de examen en la base de datos
try {
    $stmt = $db->prepare("INSERT INTO mesa_examen (nombre_mesa, id_materia, id_ciclo_lectivo, fecha, fecha_fin, hora, estado , id_tipo) VALUES (?, ?, ?, ?, ?, ?, ? , ?)");
    $stmt->bindParam(1, $nombre_mesa);
    $stmt->bindParam(2, $id_materia);
    $stmt->bindParam(3, $ciclo_lectivo);
    $stmt->bindParam(4, $fecha);
    $stmt->bindParam(5, $fecha_fin);
    $stmt->bindParam(6, $hora);
    $stmt->bindParam(7, $estado);
    $stmt->bindParam(8, $id_tipo);  // Corregido a 8

    // Ejecuta la consulta preparada
    $stmt->execute();

    echo "Mesa de examen agregada exitosamente.";
} catch (PDOException $e) {
    echo "Error al agregar la mesa de examen: " . $e->getMessage();
}
