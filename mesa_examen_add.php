<?php
require 'conn/connection.php';

// Realizar la consulta SQL para obtener las materias
$query = "SELECT id_materia, Nombre FROM materia";
$result = $db->query($query);

// Consulta SQL para obtener los ciclos lectivos
$query_ciclos = "SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo";
$result_ciclos = $db->query($query_ciclos);
?>


<?php require 'navbar.php'; ?>
<body>
    

    <div class="container mt-3 "style="width: 40rem">
        <div class="row d-flex justify-content-center ">
            <div class="col " >
            <div class="card rounded-2 border-0">
            <h5 class="card-header bg-dark text-white">Agregar Mesa de Examen</h5>
            <div class="card-body bg-light">
                <form action="procesar_mesa.php" method="post">
                        <div class="form-group">
                            <label for="materia">Materia:</label>
                            <select name="materia" id="materia" class="form-control" autocomplete="off" required>
                            <option value="" disabled selected>Elija la materia</option>
                            <?php
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['id_materia'] . "'>" . $row['Nombre'] . "</option>";
                            }
                            ?>
                            </select>                        
                        </div>   
                        <!-- ------------------------------                  -->
                        <div class="form-group">
                        
                        </div>
                    <!-- ----------------------------- -->
                    <div class="form-group">
                        <label for="nombre_mesa">Nombre de Mesa:</label>
                        <input type="text" name="nombre_mesa" autocomplete="off"  class="form-control" placeholder="Ingrese Nombre" required>
                    </div>
                    <!-- ---------------------------- -->
                    <div class="form-group">
                        <label for="fecha">Fecha Inicio:</label>
                        <input type="date" name="fecha" autocomplete="off" class="form-control" required>
                    </div>
                    <!-- ---------------------------- -->
                    <div class="form-group">
                        <label for="fecha_fin">Fecha Fin:</label>
                        <input type="date" name="fecha_fin" autocomplete="off" class="form-control" required>
                    </div>
                    <!-- ---------------------------- -->

                    <div class="form-group">
                        <label for="hora">Hora:</label>
                        <input type="time" name="hora" autocomplete="off" class="form-control" required>
                    </div>
                    <!-- ---------------------------- -->    
                    <div class="form-group">
                        <label for="id_tipo">Tipo de Materia:</label>
                        <select name="id_tipo" class="form-control" autocomplete="off" required>
                            <option value="" disabled selected>Seleccione su Tipo</option>
                            <option value="1">Regular</option>
                            <option value="2">Promocional</option>
                            <option value="3">Libre</option>
                        </select>
                    </div>
                    <!-- ---------------------------- -->
                    <label for="ciclo_lectivo">Ciclo Lectivo:</label>
                    <select name="ciclo_lectivo" id="ciclo_lectivo" class="form-control" autocomplete="off" required>
                        <option value="" disabled selected>Seleccione el ciclo lectivo</option>
                        <?php
                        while ($row_ciclo = $result_ciclos->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row_ciclo['id_ciclo'] . "'>" . $row_ciclo['nombre_ciclo'] . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <input type="submit" class="btn btn-primary"value="Agregar Mesa">
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
</body>
<?php require 'footer.php'; ?>