<!-- --------------------- -->
<?php require 'navbar.php'; ?>
<body>    
    <div class="container mt-3">
        <div class="row d-flex justify-content-center">
            <div class="col-auto">
                <div class="card rounded-2 border-0" >
                    <h5 class="card-header bg-dark text-white">Asignar materia</h5>
                    <div class="card-body bg-light">
                        <form method="post" class="form" action="asignar_i.php">

                            <!-- ---------------El get trae el id del profesor q quiere asignar la materia------------------ -->
                            <div class="form-group">
                            <?php
                                include('conn/conexion.php');
                                $sql = $conexion->query("SELECT * FROM persona WHERE id_rol = 2 AND estado = 'Activo' AND id_persona=" . $_GET['id']);
                                $resultado = $sql->fetch_assoc();                                    
                                ?>
                                <label for="profesor">Profesor:</label>
                                <input name="profesor" value="<?php echo $resultado["nombre"] . " " . $resultado["apellido"];?>" class="form-control" readonly onmousedown="return false">
                            </div>
                            <!-- --------------------------------- -->
                            <div class="form-group">
                                <label for="materia">Materia:</label>
                                <select name="materia" class="form-control" required>
                                    <option disabled selected hidden>Seleccione la materia</option>
                                    <?php
                                    include('conn/conexion.php');
                                    $sql = $conexion->query("SELECT * FROM materia");
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

</body>

</html>