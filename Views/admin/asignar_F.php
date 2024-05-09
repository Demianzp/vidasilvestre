<?php
include_once('conn/connection.php');
// Inicializar variables de mensaje
$mensj1 = '';
$error1 = '';
if (isset($_POST['profesor']) && isset($_POST['materia'])) {
    $profesor = $_POST['profesor'];
    $materia = $_POST['materia'];
    $estado = "Activo";

    $sql = "INSERT INTO asignar (id_persona, id_materia, Estado) VALUES (:profesor, :materia, :estado)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":profesor", $profesor, PDO::PARAM_INT);
    $stmt->bindParam(":materia", $materia, PDO::PARAM_INT);
    $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
    if ($stmt->execute()) {
        $mensj1 = 'Registro cargado correctamente.';
    } else {
        $error1 = 'Error al a cargar el registro: ' . implode(', ', $consulta_desactivar->errorInfo());
    }
}
// Redirigir solo si hay mensajes para enviar
if ($mensj1|| $error1) {
header("Location: lista_A.php?mensaje1=" . urlencode($mensj1) . "&error1=" . urlencode($error1));
exit();
}
    
?>

<?php require 'navbar.php'; ?>


    <div class="container mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white">Asignar materia</h5>
                    <div class="card-body bg-light">
                        <form method="post" class="form" action="">

                            <!-- ---------------El get trae el id del profesor q quiere asignar la materia------------------ -->
                            <div class="form-group">
                                <label for="profesor">Profesor:</label>
                                <select name="profesor" class="form-control" required>
                                    <option disabled selected hidden>Seleccione Profesor</option>
                                    <?php
                                    include('conn/conexion.php');
                                    $sql = $conexion->query("SELECT * FROM persona WHERE id_rol = 2 AND estado = 'Activo' AND id_persona=" . $_GET['id']);
                                    while ($resultado = $sql->fetch_assoc()) {
                                        echo "<option value='" . $resultado["id_persona"] . "'>" . $resultado["nombre"] . " " . $resultado["apellido"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- --------------------------------- -->
                            <div class="form-group">
                                <label for="materia">Materia:</label>
                                <select name="materia" class="form-control" required>
                                    <option disabled selected hidden>Seleccione la materia</option>
                                    <?php
                                    include('conn/conexion.php');
                                    $sql = $conexion->query("SELECT * FROM materia WHERE  estado = 'Activo'");
                                    while ($resultado = $sql->fetch_assoc()) {
                                        echo "<option value='" . $resultado["id_materia"] . "'>" . $resultado["Nombre"] . " </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- --------------------------------- -->
                            <div class="form-group">
                                <input type="hidden" class="form-control" name="Estado" value="Activo" disabled>
                            </div>
                            <!-------------------------------------------------------------->
                            <div class="mt-3 mb-2">
                                <button type="submit" class="btn btn-primary">Guardar </button>
                                <a class="btn btn-warning" href="lista_A.php">Ver Listado</a>
                            </div>
                            <?php
                            if (!empty($infoMessage)) {
                                echo '<div class="alert alert-success" role="alert">' . $infoMessage . '</div>';
                            }
                            if (!empty($errorMessage)) {
                                echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>';
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require 'footer.php'; ?>