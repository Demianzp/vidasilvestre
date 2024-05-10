<?php
// Conexión a la base de datos
require '../../conn/connection.php'; 
//-------------BORRADO------------------ 
if(isset($_GET['txtID'])){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$db->prepare("UPDATE materia SET estado = 'Inactivo' WHERE id_materia = :id" );
    $sentencia->bindParam(':id',$txtID);
    $sentencia->execute();
    $mensaje="Registro Materia Eliminado";
    header("Location:materia_index.php?mensaje=".$mensaje);
  }
// --------------------------------------------------------------
// Inicializar la variable del ciclo actual antes de usarla
// $ciclo_actual = null;

// try {
//     // Consulta para obtener el ciclo lectivo actual
//     $stmt = $db->prepare("SELECT nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1");
//     $stmt->execute();
//     $ciclo_actual = $stmt->fetch(PDO::FETCH_ASSOC);

//     // Si la consulta no devuelve resultados, inicializar con un valor por defecto
//     if ($ciclo_actual === false) {
//         $ciclo_actual = array("nombre_ciclo" => "No definido");
//     }
// } catch (PDOException $e) {
//     // Manejo de errores y uso de valor por defecto
//     $ciclo_actual = array("nombre_ciclo" => "No definido");
//     error_log("Error al obtener el ciclo lectivo actual: " . $e->getMessage());
// }

// Requerir la barra de navegación
require 'navbar.php'; 
?>

<!-- Sección de contenido -->
<section class="content mt-2">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">Listado de Materias y Correlativas</h5>
                    <a class="btn btn-primary float-right mb-2" href="materia_crea.php">Registro de Materia</a>
                </div>
                
                <!-- Mostrar el ciclo lectivo actual -->
                <!-- <div class="mt-3 m-2">
                    <h6>
                        Ciclo Lectivo Actual:
                        <strong><?php echo htmlspecialchars($ciclo_actual['nombre_ciclo'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    </h6>
                </div> -->
                <!-- Tabla de materias -->
                <div class="card-body table-responsive">
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID Materia</th>
                                <th>Materia</th>
                                <th>Agregar Correlativa</th>
                                <th>Acciones</th>
                                <th>Listado de Alumnos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $query = "SELECT m.id_materia, m.Nombre AS 'Materia', c.id_correlativa, c.id_materia AS 'Correlativa'
                                              FROM materia m
                                              LEFT JOIN correlativa c ON m.id_materia = c.id_materia
                                              WHERE m.estado = 'Activo'";
                                $stmt = $db->prepare($query);
                                $stmt->execute();
                                $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($materias as $materia) {
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($materia['id_materia'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($materia['Materia'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-center">
                                            <a href="correlativas.php?id=<?php echo htmlspecialchars($materia['id_materia'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-success btn-sm"><i class="fa-sharp fa-solid fa-folder-open"></i></a>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="materia_edit.php?id=<?php echo htmlspecialchars($materia['id_materia'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-warning btn-sm" role="button"><i class="fas fa-edit"></i></a>
                                                <a href="javascript:eliminar3(<?php echo $materia['id_materia'];?>)" class="btn btn-danger btn-sm" title="Borrar" role="button">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="text-center"><a href="materia_alumno.php?id=<?php echo htmlspecialchars($materia['id_materia'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-success btn-sm">Listado de Alumnos</a></td>
                                    </tr>
                            <?php
                                }
                            } catch (PDOException $e) {
                                error_log("Error al obtener las materias: " . $e->getMessage());
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="js/ocultarMensaje.js"></script>
<?php require 'footer.php'; ?>
