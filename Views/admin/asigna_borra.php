<?php
require '../../conn/connection.php';

// Inicializar variables de mensaje
$mensj3 = '';
$error3 = '';

if (isset($_GET['id'])) {
   
    $id_materia = $_GET['id'];

    if (isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        
        // El usuario confirmó la desactivación, proceder con la actualización del estado
         $fecha_baja = $_POST['fecha_baja'];
        $consulta_desactivar = $db->prepare("INSERT ON asignar (fecha_b) VALUES (:fecha_baja) SET Estado = 'Inactivo' WHERE id_asignar = :id");
        $consulta_desactivar->bindParam(':id', $id_asignar, PDO::PARAM_INT);

        if ($consulta_desactivar->execute()) {
            $mensj3 = 'Registro desactivado correctamente';
        } else {
            $error3 = 'Error al desactivar el registro: ' . implode(', ', $consulta_desactivar->errorInfo());
        }
    }
} 
// Redirigir solo si hay mensajes para enviar
if ($mensj3|| $error3) {
    header("Location: asigna_index.php?mensaje3=" . urlencode($mensj3) . "&error3=" . urlencode($error3));
    exit();
}
?>

<!-- -------------------------------------------- -->

    <?php require 'navbar.php'; ?>
    <div class="body">
        <div class="panel">
            <?php if (empty($errMessage)) { // Mostrar confirmación solo si no hay un error 
            ?>
                <!-- --------------------------------- -->
                <div class="container mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white">¿Está seguro de que desea dar de baja al profesor?</h5>
                    <div class="card-body bg-light">
                     
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="fecha_baja">Fecha de salida:</label>
                                <input type="date" class="form-control" name="fecha_baja" required>
                            </div>
                        </div>
                        </div>

                <a class="btn btn-danger" href="?id=<?php echo $id_materia; ?>&confirm=yes">Sí</a>
                <a class="btn btn-primary" href="asigna_index.php">No</a>
            <?php } else { ?>
                <a class="btn btn-warning" href="asigna_index.php">Volver al Listado</a>
            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
                
        </div>
    </div>
<?php require 'footer.php'; ?>
