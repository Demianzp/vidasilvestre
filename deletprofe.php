<?php
require 'conn/connection.php';

// Inicializar variables de mensaje
$infoMessage = '';
$errorMessage = '';

if (isset($_GET['id'])) {
    $id_profe = $_GET['id'];

    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // El usuario confirmó la desactivación, proceder con la actualización del estado
        $consulta_desactivar = $db->prepare("UPDATE persona SET estado = 'Inactivo' WHERE id_persona = :id");
        $consulta_desactivar->bindParam(':id', $id_profe, PDO::PARAM_INT);

        if ($consulta_desactivar->execute()) {
            $infoMessage = 'Registro desactivado correctamente';
        } else {
            $errorMessage = 'Error al desactivar el registro: ' . implode(', ', $consulta_desactivar->errorInfo());
        }
    }
} else {
    $errorMessage = 'Ha ocurrido un error: Falta el ID del alumno en la URL.';
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
<?php require '../navbar.php'; ?>

<div class="body">
    <div class="panel">
        <h4>Desactivar Profesor</h4>
        <!-- Muestra mensajes de éxito o error ------->
        <?php
        if (!empty($infoMessage)) {
            echo '<div class="alert alert-primary" role="alert">' .$infoMessage. '</div>';
            
        }
        if (!empty($errorMessage)) {
            echo '<div class="alert alert-primary" role="alert">' . $errorMessage . '</div>';
        }
        ?>
        <br><br>
        
        <?php if (empty($errorMessage)) { // Mostrar confirmación solo si no hay un error ?>
            <p>¿Está seguro de que desea desactivar este registro?</p>
            <a class="btn btn-danger" href="?id=<?php echo $id_profe; ?>&confirm=yes">Sí</a>
            <a class="btn btn-primary" href="../listadoprofe.php">No</a>
        <?php } else { ?>
            <a class="btn btn-warning" href="../listadoprofe.php">Volver al Listado</a>
        <?php } ?>
    </div>
</div>
<?php require 'footer.php'; ?>
</body>
</html>
