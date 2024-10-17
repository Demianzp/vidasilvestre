<?php
require '../../conn/connection.php';
//-------------BORRADO------------------ 
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $db->prepare("UPDATE persona SET estado = 'Inactivo' WHERE id_persona = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $mensaje = "Registro Alumno Eliminado";
    header("Location:mesa_acta.php?mensaje=" . $mensaje);
}
?>
<?php require 'navbar.php'; ?>
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header pb-0 bg-dark text-white ">
                    <h5 class="d-inline-block ">Listado de Alumnos a convocar</h5>
                    <a class="btn btn-primary float-right mb-2" href="alumno_crea.php">Gestionar nota</a>
                </div>
                <!-- -------------------- -->
                <div class="card-body table-responsive">
                    <form  action="" method="post">
                        <table id="example" class="table table-striped table-sm" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Apellido y Nombre</th>
                                    <th>DNI</th>
                                    <th>Estado</th>
                                    <th>Escrito</th>
                                    <th>Definitivo</th>





                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
                                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $query = "SELECT * FROM persona WHERE id_rol = 1 AND estado = 'Activo'";
                                    $stmt = $db->prepare($query);
                                    $stmt->execute();
                                    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($alumnos as $alumno) {
                                ?>
                                        <tr>
                                           
                <th scope="row">
                    <!-- Campo checkbox para seleccionar -->
                    <input type="checkbox" name="seleccionar[]" value="<?php echo $alumno['id_persona']; ?>">
                </th>


                                            <!-- ------------- -->

                                            <td><?php echo $alumno['apellido']; ?> <?php echo $alumno['nombre']; ?></td>
                                            <td><?php echo $alumno['DNI'] ?></td>
                                            <td>
                                            </td>





                                            <!-- ------------- -->

                                            <td> </td>
                                            <td>
                                                
                                            </td>
                                          
                                        </tr>
                                <?php
                                    }
                                } catch (PDOException $e) {
                                    echo "Error de conexión: " . $e->getMessage();
                                }
                                ?>
                            </tbody>
                        </table>
                    </form>
                    <br>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</section>