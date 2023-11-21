<?php
require 'conn/connection.php';

// Inicializar variables de mensaje
$inMessage = '';
$errMessage = '';

if (isset($_GET['id_asignar'])) {
    $id_asignar = $_GET['id_asignar'];

    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // El usuario confirmó la desactivación, proceder con la actualización del estado
        $consulta_desactivar = $db->prepare("UPDATE  asignar SET Estado = 'Activo'  WHERE id_asignar = :id_asignar");
        $consulta_desactivar->bindParam(':id_asignar', $id_asignar, PDO::PARAM_INT);

        if ($consulta_desactivar->execute()) {
            $inMessage = '!!Registro desactivado correctamente !!';
        } else {
            $errMessage = '!!Error al desactivar el registro!!: ' . implode(', ' . $consulta_desactivar->errorInfo());
        }
    }
}
// Redirigir solo si hay mensajes para enviar
if ($inMessage || $errMessage) {
    header("Location: lista_A.php?mensaje=" . urlencode($inMessage) . "&error=" . urlencode($errMessage));
    exit();
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoI6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Desactivar Profesor</title>
    <meta name="description" content="Desactivar profesor" />
</head>

<body>
    <?php require 'navbar.php'; ?>

    <div class="body">
        <div class="panel">
            <h4>Desactivar </h4>
            <!-- Muestra mensajes de éxito o error ------->

            <br><br>
            <?php if (empty($errorMessage)) { // Mostrar confirmación solo si no hay un error 
            ?>
                <p>¿Está seguro de que desea desactivar este registro?</p>
                <a class="btn btn-danger" href="?id=<?php echo $id_asignar; ?>&confirm=yes">Sí</a>
                <a class="btn btn-primary" href="lista_A.php">No</a>
            <?php } else { ?>
                <a class="btn btn-warning" href="lista_A.php">Volver al Listado</a>
            <?php } ?>
        </div>
    </div>
    <?php require 'footer.php'; ?>
</body>

</html>