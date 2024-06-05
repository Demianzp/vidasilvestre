<?php 
require '../../conn/connection.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
   $materia_id = null;
   $mensaje = null;
   $error = null;
    
   $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
   // Guardar la materia
   $nombre = $_POST["nombre"];
   $descripcion = $_POST["descripcion"];
   $horas = (int)$_POST["horas"];
   $num_resolucion = (int)$_POST["num_resolucion"];
   $plan_estudio = $_POST["plan_estudio"];
   $año_cursado = $_POST["año"];
   $id_tipo = (int)$_POST["id_tipo"];
   $estado = 'Activo';
   try{
        $sql = "INSERT INTO materia (Nombre, descripcion, horas, num_resolucion, plan_estudio, año_cursado, id_tipo, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(1, $nombre);
        $stmt->bindParam(2, $descripcion);
        $stmt->bindParam(3, $horas, PDO::PARAM_INT);
        $stmt->bindParam(4, $num_resolucion, PDO::PARAM_INT);
        $stmt->bindParam(5, $plan_estudio);
        $stmt->bindParam(6, $año_cursado);
        $stmt->bindParam(7, $id_tipo, PDO::PARAM_INT);
        $stmt->bindParam(8, $estado);

        if ($stmt->execute()) {
            $materia_id = $db->lastInsertId();
            $mensaje = "Materia ingresada con éxito.";
            // Guardar las correlativas seleccionadas
            if (isset($_POST['correlativas'])) {
                $correlativas = $_POST['correlativas'];
                foreach ($correlativas as $correlativa) {
                    $sql = "INSERT INTO correlativa (id_materia, id_correlativa) VALUES (?, ?)";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam(1, $materia_id, PDO::PARAM_INT);
                    $stmt->bindParam(2, $correlativa, PDO::PARAM_INT);
                    $stmt->execute();
                }
                $mensaje .= " Correlativas guardadas con éxito.";
            }
        } else {
            $error = "Error al ingresar Materia: " . $stmt->errorInfo()[2];
        }        
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();        
    }
}
?>
<!-- ----------------------------------------------------- -->
<?php require 'navbar.php'; ?>
<!-- ----------------------------------------------------- -->
<div class="container mt-2 ">        
    <div class="card rounded-2 border-0">
        <h5 class="card-header bg-dark text-white">Registro de Materias</h5>
        <div class="card-body">
            <form method="post" action="">
                <div class="row">
                    <div class="col">     
                        <br>
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingrese el Nombre" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción:</label>
                            <input type="text" class="form-control" name="descripcion" placeholder="Ingrese Descripcion" id="descripcion" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="horas">Horas de cursada:</label>
                            <input type="number" class="form-control" name="horas" id="horas" placeholder="Ingrese las horas" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="num_resolucion">Número de Resolución:</label>
                            <input type="text" class="form-control" id="num_resolucion" name="num_resolucion" placeholder="Ingrese N° de Resolucion" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="año">Año de Cursado:</label>
                            <select name="año" id="año" class="form-control" autocomplete="off" required>
                                <option value="" disabled selected>Seleccione Año de Cursado</option>
                                <option value="1">1° Año</option>
                                <option value="2">2° Año</option>
                                <option value="3">3° Año</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="plan_estudio">Cuatrimestre</label>
                            <select name="plan_estudio" id="plan_estudio" class="form-control" autocomplete="off" required>
                                <option value="" disabled selected>Seleccione el Cuatrimestre</option>
                                <option value="1">1° Cuatrimestre</option>
                                <option value="2">2° Cuatrimestre</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_tipo">Tipo de Materia:</label>
                            <select name="id_tipo" class="form-control" autocomplete="off" required>
                                <option value="" disabled selected>Seleccione su Tipo</option>
                                <option value="1">Promocional</option>
                                <option value="2">Regular</option>
                                <option value="3">Libre</option>
                            </select>
                        </div>
                    </div>
                    <!-- -------------------------------------------------------- -->
                    <div class="col">
                        <!-- ---------------------------------------------- -->
                        <div class="card-body table-responsive pt-0">
                            <table id="" class="table table-striped table-sm" style="width:100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Materia</th>
                                        <th>Seleccione</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = $db->query("SELECT * FROM materia WHERE estado = 'Activo'");
                                    while ($resultado = $sql->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $resultado["id_materia"] ?></td>
                                            <td><?php echo $resultado["Nombre"] ?></td> 
                                            <td> 
                                                <div class="form-check checkbox-xl d-flex justify-content-center">
                                                    <input type="checkbox" class="form-check-input" name="correlativas[]" value="<?php echo $resultado["id_materia"]; ?>">
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }                                                
                                    ?>
                                </tbody>
                            </table>
                            <!--Aretglar boton-->
                            <button type="button" class="btn btn-primary float-right" id="guardarBtn" onclick="validarFormulario()">Guardar</button>
                            <!-- Div para el mensaje de confirmación -->
                            <div id="confirmacion" style="display: none;">
                                <p>¿Estás seguro de que deseas guardar los datos?</p>
                                <button type="button" class="btn btn-success" id="confirmarBtn">Sí</button>
                                <button type="button" class="btn btn-danger" id="cancelarBtn">No</button>
                            </div>
                        </div>
                    </div>                        
                                               
                </div>
            </form>
            <!-- ----------------------------------------------       --> 
            <?php if (isset($mensaje)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $mensaje; ?>
                </div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            <!-- ----------------------------------------------       --> 
        </div>
    </div>
</div>
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>
<?php require 'footer.php'; ?>
