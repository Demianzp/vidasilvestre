<?php
require_once('../../conn/connection.php');

if (isset($_POST['id_mesa']) && isset($_POST['seleccionar'])) {
    $id_mesa = $_POST['id_mesa'];
    $alumnos = $_POST['seleccionar'];

    $insert_sql = "INSERT INTO acta(dni, ape_nom, id_mesa) VALUES (:dni, :ape_nom, :id_mesa)";
    $insert_stmt = $db->prepare($insert_sql);

    foreach ($alumnos as $alumno_id) {
        // Consultar la información del alumno seleccionado
        $query = "SELECT dni, CONCAT(nombre, ' ', apellido) AS ape_nom FROM persona WHERE id_persona = :alumno_id";
        $alumno_stmt = $db->prepare($query);
        $alumno_stmt->bindParam(':alumno_id', $alumno_id, PDO::PARAM_INT);
        $alumno_stmt->execute();
        $alumno_info = $alumno_stmt->fetch(PDO::FETCH_ASSOC);

        // Si se encuentra el alumno, proceder a la inserción
        if ($alumno_info) {
            $dni = $alumno_info['dni'];
            $ape_nom = $alumno_info['ape_nom'];

            $insert_stmt->bindParam(":dni", $dni, PDO::PARAM_STR);
            $insert_stmt->bindParam(":ape_nom", $ape_nom, PDO::PARAM_STR);
            $insert_stmt->bindParam(":id_mesa", $id_mesa, PDO::PARAM_INT);
            $insert_stmt->execute(); // Ejecutar la inserción para cada alumno
        }
    }
}

// Consulta para obtener los alumnos
$query = "SELECT * FROM inscripcion 
          INNER JOIN persona ON inscripcion.id_alumno = persona.id_persona AND persona.estado = 'Activo'
          INNER JOIN mesa_examen ON inscripcion.id_mesa_examen = mesa_examen.id_mesa AND mesa_examen.estado = 'Activo' 
          WHERE id_mesa_examen = :id_mesa_examen";

$stmt = $db->prepare($query);
$stmt->bindParam(':id_mesa_examen', $_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

require 'navbar.php'; 
?>

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header pb-0 bg-dark text-white">
                    <h5 class="d-inline-block">Listado de Alumnos a convocar</h5>
                </div>
                <div class="card-body table-responsive">
                    <form action="" method="post">
                        <input type="hidden" name="id_mesa" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                        
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <h5 class="d-inline-block"><strong><?php echo htmlspecialchars($resultados[0]['nombre_mesa']); ?><br></strong></h5> 
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
                                <?php foreach ($resultados as $resultado): ?>
                                    <tr>
                                        <th scope="row">
                                            <input type="hidden" name="id_mesa_examen" value="<?php echo htmlspecialchars($resultado['id_mesa']); ?>">
                                            <input type="checkbox" name="seleccionar[]" value="<?php echo htmlspecialchars($resultado['id_alumno']); ?>">
                                        </th>
                                        <td><?php echo htmlspecialchars($resultado['nombre'] . " " . $resultado['apellido']); ?></td>
                                        <td><?php echo htmlspecialchars($resultado['DNI']); ?></td>
                                        <td></td>     
                                        <td></td>   
                                        <td></td>           
            
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-success">Guardar Selección</button>
                    </form>
                    <br>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</section>
