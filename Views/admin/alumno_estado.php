<?php require 'navbar.php'; ?>

<?php
// Conexión a la base de datos
require '../../conn/connection.php';

// Obtener el ID del alumno de la URL
$alumno_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($alumno_id) {
    // Obtener las materias disponibles desde la base de datos
    $sql = "SELECT id_materia, Nombre FROM materia";
    $result = $conexion->query($sql);

    $materias = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $materias[] = $row;
        }
    } else {
        echo "No se encontraron materias.";
    }

    // Obtener el estado del alumno en las materias
    $sql_estado = "SELECT id_materia, estado FROM alumno_materia WHERE id_persona= $alumno_id";
    $result_estado = $conexion->query($sql_estado);

    $estado_alumno = [];
    if ($result_estado->num_rows > 0) {
        while ($row_estado = $result_estado->fetch_assoc()) {
            $estado_alumno[$row_estado['id_materia']] = $row_estado['estado'];
        }
    }

    $conexion->close();
} else {
    echo "ID de alumno no especificado.";
    exit;
}
?>

<section class="content mt-2">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <h5 class="d-inline-block">*Nombre y Apellido del alumno*</h5>
                    <a class="btn btn-primary float-right mb-2" href="">Información</a>                    
                </div>
                <div class="card-body table-responsive">
                    <table id="" class="table table-bordered table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Materia</th>
                                <th>Inscribir</th>
                                <th>Nota 1</th>
                                <th>Nota 2</th>
                                <th>Nota 3</th>
                                <th>Nota 4</th>
                                <th>Nota F</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materias as $index => $materia): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($materia['Nombre']); ?></td>
                                    <td>
                                        <?php if (isset($estado_alumno[$materia['id_materia']]) && $estado_alumno[$materia['id_persona']] == 'Inscripto'): ?>
                                            <div class="bg-success text-white text-center">Inscripto</div>
                                        <?php else: ?>
                                            <form action="alumno_inscripcion.php" method="post">
                                                <input type="hidden" name="alumno_id" value="<?php echo htmlspecialchars($alumno_id); ?>">
                                                <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($materia['id_materia']); ?>">
                                                <button type="submit" class="btn btn-danger btn-sm btn-block">Inscribir</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                    <td>nota1</td>
                                    <td>nota2</td>
                                    <td>nota3</td>
                                    <td>nota4</td>
                                    <td>notaf</td>
                                    <td><?php echo isset($estado_alumno[$materia['id_materia']]) ? htmlspecialchars($estado_alumno[$materia['id_persona']]) : 'libre'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>    
            </div> 
        </div>   
    </div>
</section>

<?php require 'footer.php'; ?>
