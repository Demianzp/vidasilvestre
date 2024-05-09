<?php
require 'conn/connection.php';

// Inicializar variables de mensaje
$mensj3 = '';
$error3 = '';

if (isset($_GET['id'])) {
    $id_materia = $_GET['id'];

    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // El usuario confirmó la desactivación, proceder con la actualización del estado
        $consulta_desactivar = $db->prepare("UPDATE asignar SET Estado = 'Inactivo' WHERE id_asignar = :id");
        $consulta_desactivar->bindParam(':id', $id_materia, PDO::PARAM_INT);

        if ($consulta_desactivar->execute()) {
            $mensj3 = 'Registro desactivado correctamente';
        } else {
            $error3 = 'Error al desactivar el registro: ' . implode(', ', $consulta_desactivar->errorInfo());
        }
    }
} 
// Redirigir solo si hay mensajes para enviar
if ($mensj3|| $error3) {
    header("Location: lista_A.php?mensaje3=" . urlencode($mensj3) . "&error3=" . urlencode($error3));
    exit();
}
?>
<!-- -------------------------------------------- -->

    <?php require 'navbar.php'; ?>
    <div class="body">
        <div class="panel">
            <h4>Desactivar </h4>
            <?php if (empty($errMessage)) { // Mostrar confirmación solo si no hay un error 
            ?>
                <p>¿Está seguro de que desea desactivar este registro?</p>
                <a class="btn btn-danger" href="?id=<?php echo $id_materia; ?>&confirm=yes">Sí</a>
                <a class="btn btn-primary" href="lista_A.php">No</a>
            <?php } else { ?>
                <a class="btn btn-warning" href="lista_A.php">Volver al Listado</a>
            <?php } ?>
        </div>
    </div>
<?php require 'footer.php'; ?>
