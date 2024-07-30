<?php require 'navbar.php'; ?>
<p>hacer un formulario simple que guarde estos valores</p>
Guarda:
-alumno
-materia
-tipo de examen.
-cilco lectivo
-nota
    <div class="container mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white">Asignar materia</h5>
                    <div class="card-body bg-light">
                        <form method="post" class="form" action="">
                           <div class="form-group">
                                <label  for="profesor">Profesor:</label>
                            </div>
                                <!-- --------------------------------- -->
                                <div class="row">
                               <div class="col">
                            <div class="form-group">
                                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                                <input type="date" class="form-control" name="fecha_ingreso" required>
                            </div>
                                </div>
                                </div>
                            <!-- --------------------------------- -->
                            <div class="form-group">
                                <label for="materia">Materia:</label>
                                <select name="materia" class="form-control" required>
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
                            
                            <!-------------------------------------------------------------->
                            <div class="mt-3 mb-2">
                                <button type="submit" class="btn btn-primary">Guardar </button>
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