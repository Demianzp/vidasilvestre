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
                    <h5 class="d-inline-block ">Gestión de nota</h5>
                    <a class="btn btn-primary float-right mb-2" href="#.php">Gestionar nota</a>
                </div>
                  <!-- -------------------- -->
                  <?php
require '../../conn/connection.php';
$query = "SELECT mesa_examen.*, 
materia.nombre AS nombre_materia, 
ciclo_lectivo.nombre_ciclo,
nombre_tipo AS nombre_tipo,
tribunal.presidente
FROM mesa_examen 
INNER JOIN materia ON mesa_examen.id_materia = materia.id_materia
LEFT JOIN ciclo_lectivo ON mesa_examen.id_ciclo = ciclo_lectivo.id_ciclo
LEFT JOIN tribunal ON mesa_examen.id_t = tribunal.id_t
LEFT JOIN tipo ON mesa_examen.id_tipo = tipo.id_tipo WHERE  mesa_examen.estado= 'Activo'";
$result = $db->query($query);
?>
 <div class="card-body table-responsive">
                <?php
              
                ?>
                <table id="example" class="table table-striped table-bordered  " cellspacing="0" width="100%"><h5 class="d-inline-block "><strong>Mesa de examen</strong></h5>
                    <thead class="thead-dark">
                            <th>Seleccionar</th>
                            <th>Nombre de Mesa</th>
                            <th>Presidente de mesa</th>
                            <th>Materia</th>
                            <th>Hora</th>
                            <th>Fecha </th>
                            <th>Libro</th>
                            <th>Folio</th>
                            <th>Ciclo Lectivo</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        <?php
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['id_mesa'] . "</td>";
                            echo "<td>" . $row['nombre_mesa'] . "</td>";
                            echo "<td>" . $row['presidente'] . "</td>";
                            echo "<td>" . $row['nombre_materia'] . "</td>";
                            echo "<td>" . $row['hora'] . "</td>";
                            echo "<td>" . $row['fecha'] . "</td>";
                            echo "<td>" . $row['libro'] . "</td>";
                            echo "<td>" . $row['folio'] . "</td>";
                            echo "<td>" . $row['nombre_ciclo'] . "</td>";
                            echo "<td>" . $row['nombre_tipo'] . "</td>";    
                        ?>
                        

                             <?php
                               echo "</tr>";
                                }
                                ?>
                    </tbody>
                </table>
            </div>
                <!-- -------------------- -->
                <div class="card-body table-responsive">
                    <form  action="" method="post">
                        <table id="example" class="table table-striped table-sm" style="width:100%"><h5 class="d-inline-block "><strong>Acta de examen</strong></h5>
                            <thead class="thead-dark">
                                <tr>
                                  
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

                  <!-- -------------------- -->


            </div>
        </div>
    </div>
</section>