<?php

require_once('../../conn/connection.php');

$mensj1 = '';
$error1 = '';

if (isset($_POST['alumno'], $_POST['materia'], $_POST['ciclo_lectivo'], $_POST['examen'], $_POST['nota'])) {
    // Asignar los valores de $_POST a variables
    $alumno = $_POST['alumno'];
    $materia = $_POST['materia'];
    $ciclo = $_POST['ciclo_lectivo'];
    $examen = $_POST['examen'];
    $nota = $_POST['nota'];

    // Preparar la consulta SQL
    $sql = "INSERT INTO nota (id_persona, id_materia, id_ciclo, id_examen_tipo, nota) 
            VALUES (:alumno, :materia, :ciclo, :examen, :nota)";
    $stmt = $db->prepare($sql);

    // Vincular los parámetros con los valores
    $stmt->bindParam(":alumno", $alumno, PDO::PARAM_INT);
    $stmt->bindParam(":materia", $materia, PDO::PARAM_INT);
    $stmt->bindParam(":ciclo", $ciclo, PDO::PARAM_INT);
    $stmt->bindParam(":examen", $examen, PDO::PARAM_INT); // Si es un ID, podría ser INT
    $stmt->bindParam(":nota", $nota, PDO::PARAM_STR);

    try {
        // Ejecutar la consulta preparada
        $stmt->execute();
        $mensj1 = 'Registro cargado correctamente.';
    } catch (PDOException $e) {
        $error1 = 'Error al cargar el registro: ' . $e->getMessage();
    }
}



if ($mensj1 || $error1) {
    header("Location: nota_alumno.php?mensaje1=" . urlencode($mensj1) . "&error1=" . urlencode($error1));
    exit();
}
?>
<?php require 'navbar.php'; ?>


    <div class="container mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white">Asignar Nota</h5>
                    <div class="card-body bg-light">
                        <form method="post" class="form" action="">

                        <!-- --------------------------------- -->
                        <div class="row">
                        <div class="col">
                           <div class="form-group">
                                <label  for="alumno">Alumno:
                                <select class="form-select"  name="alumno"  >
                           
                                    <?php
                                    $sql = $conexion->query("SELECT * FROM persona WHERE id_rol = 1 AND estado = 'Activo'");
                                    while ($resultado = $sql->fetch_assoc()) {
                                        echo "<option value='" . $resultado["id_persona"] . "'>" . $resultado["nombre"] . " " . $resultado["apellido"] . "</option>";
                                    }
                                    ?>
                                </select></label>
                            </div>
                            </div>
                            </div>
                            <!-- --------------------------------- -->
                            <div class="form-group">
                                <label for="materia">Materia:</label>
                                <select name="materia" class="form-select" required>
                                    <option disabled selected hidden>Seleccione la materia</option>
                                    <?php
                                    $sqlm = $conexion->query("SELECT * FROM materia WHERE  estado = 'Activo'");
                                    while ($resultadom = $sqlm->fetch_assoc()) {
                                        echo "<option value='" . $resultadom["id_materia"] . "'>" . $resultadom["Nombre"] . " </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                          <!-- --------------------------------- -->
                        
                                <div class="form-group">
                                <label for="ciclo_lectivo">Ciclo Lectivo:</label>
                                <select name="ciclo_lectivo" class="form-select"  required>
                                    <option disabled selected hidden>Seleccione el ciclo lectivo</option>
                                    <?php
                                    $sqlCL = $conexion->query("SELECT * FROM ciclo_lectivo WHERE Estado = 'Activo'");
                                    while ($resulc = $sqlCL->fetch_assoc()) {
                                        echo "<option value='" . $resulc["id_ciclo"] . "'>" . $resulc["nombre_ciclo"] . " </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- --------------------------------- -->
                            <div class="form-group">
                                <label for="examen">Examen:</label>
                                <select name="examen" class="form-select"  required>
                                    <option disabled selected hidden>Seleccione la materia</option>
                                    <?php
                                    $sqlm = $conexion->query("SELECT * FROM examen WHERE id_examen_tipo BETWEEN 1 AND 4 ");
                                    while ($resulex = $sqlm->fetch_assoc()) {
                                        echo "<option value='" . $resulex["id_examen_tipo"] . "'>" . $resulex["nombre_examen"] . " </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                          <!-- --------------------------------- -->
                        <div class="form-group">
                            <label for="nota">Nota:</label>
                            <input type="number" class="form-control" name="nota" autocomplete="off" placeholder="Ingrese nota" required>
                        </div>
              



                        
                            <!-------------------------------------------------------------->
                            <div class="mt-3 mb-2">
                                <button type="submit" class="btn btn-primary">Guardar </button>
                                <a class="btn btn-warning" href="'?.php">Ver Listado</a>
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