<?php
require '../../conn/connection.php';

function showAlert($type, $title, $message)
{
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '$type',
                title: '$title',
                text: '$message',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'materia_index.php';
                }
            });
        });
    </script>";
}

function obtenerTiposMateria($db)
{
    $consulta_tipos = $db->query("SELECT * FROM tipo");
    return $consulta_tipos->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerMateriasDisponibles($db)
{
    $consulta_materias = $db->query("SELECT * FROM materia");
    return $consulta_materias->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerCorrelativasMateria($db, $id_materia)
{
    $consulta_correlativas = $db->prepare("SELECT id_correlativa FROM correlativa WHERE id_materia = ?");
    $consulta_correlativas->execute([$id_materia]);
    return $consulta_correlativas->fetchAll(PDO::FETCH_COLUMN);
}

function actualizarMateria($db, $id_materia, $nombre, $descripcion, $horas, $num_resolucion, $plan_estudio, $año, $id_tipo)
{
    $consulta_actualizar = $db->prepare("UPDATE materia SET Nombre = ?, descripcion = ?, horas = ?, num_resolucion = ?, plan_estudio = ?, año_cursado = ?, id_tipo = ? WHERE id_materia = ?");
    return $consulta_actualizar->execute([$nombre, $descripcion, $horas, $num_resolucion, $plan_estudio, $año, $id_tipo, $id_materia]);
}

function eliminarCorrelativas($db, $id_materia)
{
    $consulta_eliminar_correlativas = $db->prepare("DELETE FROM correlativa WHERE id_materia = ?");
    return $consulta_eliminar_correlativas->execute([$id_materia]);
}

function insertarCorrelativas($db, $id_materia, $correlativas)
{
    $consulta_insertar_correlativas = $db->prepare("INSERT INTO correlativa (id_materia, id_correlativa) VALUES (?, ?)");
    foreach ($correlativas as $id_correlativa) {
        $consulta_insertar_correlativas->execute([$id_materia, $id_correlativa]);
    }
}

function obtenerMateriaPorId($db, $id_materia)
{
    $consulta = $db->prepare("SELECT * FROM materia WHERE id_materia = ?");
    $consulta->execute([$id_materia]);
    return $consulta->fetch(PDO::FETCH_ASSOC);
}

function agruparMateriasPorAñoYPlan($materias)
{
    $agrupadas = [];

    foreach ($materias as $materia) {
        $año = $materia['año_cursado'];
        $plan = $materia['plan_estudio'];
        $agrupadas[$año][$plan][] = $materia;
    }

    return $agrupadas;
}

$tipos = obtenerTiposMateria($db);
$materias_disponibles = obtenerMateriasDisponibles($db);
$materias_agrupadas = agruparMateriasPorAñoYPlan($materias_disponibles);
$correlativas_actuales = [];
$consulta_materias = null;
$materia_actual = null;

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_materia = $_GET['id'];
    $consulta_materias = obtenerMateriaPorId($db, $id_materia);
    $correlativas_actuales = obtenerCorrelativasMateria($db, $id_materia);
    $materia_actual = $consulta_materias; // Asignar la materia actual

    if (!$consulta_materias) {
        showAlert('error', 'Error', 'No se encontró la materia con el ID: ' . htmlspecialchars($id_materia));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id_materia = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $horas = $_POST['horas'];
        $num_resolucion = $_POST['num_resolucion'];
        $plan_estudio = $_POST['plan_estudio'];
        $año = $_POST['año'];
        $id_tipo = $_POST['id_tipo'];
        $correlativas = isset($_POST['correlativas']) ? $_POST['correlativas'] : [];

        $db->beginTransaction();

        try {
            if (!actualizarMateria($db, $id_materia, $nombre, $descripcion, $horas, $num_resolucion, $plan_estudio, $año, $id_tipo)) {
                throw new Exception("Error al actualizar la materia.");
            }

            if (!eliminarCorrelativas($db, $id_materia)) {
                throw new Exception("Error al eliminar las correlativas existentes.");
            }

            if (!empty($correlativas)) {
                insertarCorrelativas($db, $id_materia, $correlativas);
            }

            $db->commit();

            showAlert('success', 'Éxito', 'Materia y correlativas actualizadas correctamente.');
        } catch (Exception $e) {
            $db->rollBack();
            showAlert('error', 'Error', $e->getMessage());
        }
    } else {
        showAlert('error', 'Error', 'Falta el ID de la materia.');
    }
}
?>

<?php require 'navbar.php'; ?>
<div class="container mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <h5 class="card-header bg-dark text-white">Edición de Materia</h5>
                <div class="card-body bg-light">
                    <?php if ($consulta_materias): ?>
                        <form method="post" class="form" action="">

                            <input type="hidden" class="form-control" name="id" value="<?php echo htmlspecialchars($consulta_materias['id_materia']); ?>">

                            <label for="nombre">Nombres:</label>
                            <input type="text" class="form-control" required name="nombre" autocomplete="off" value="<?php echo htmlspecialchars($consulta_materias['Nombre']); ?>" maxlength="45">

                            <label for="descripcion">Descripción:</label>
                            <input type="text" class="form-control" required name="descripcion" autocomplete="off" value="<?php echo htmlspecialchars($consulta_materias['descripcion']); ?>" maxlength="45">

                            <label for="horas">Horas de cursada:</label>
                            <input type="text" class="form-control" required name="horas" id="horas" autocomplete="off" value="<?php echo htmlspecialchars($consulta_materias['horas']); ?>" maxlength="8">

                            <label for="num_resolucion">Número de resolución:</label>
                            <input type="text" class="form-control" required name="num_resolucion" id="num_resolucion" autocomplete="off" value="<?php echo htmlspecialchars($consulta_materias['num_resolucion']); ?>" maxlength="10">

                            <label for="año">Año de Cursado:</label>
                            <select name="año" id="año" class="form-control" autocomplete="off" required>
                                <option value="" disabled>Seleccione su Año de Cursado</option>
                                <option value="1° Año" <?php echo ($consulta_materias['año_cursado'] == '1° Año') ? 'selected' : ''; ?>>1° Año</option>
                                <option value="2° Año" <?php echo ($consulta_materias['año_cursado'] == '2° Año') ? 'selected' : ''; ?>>2° Año</option>
                                <option value="3° Año" <?php echo ($consulta_materias['año_cursado'] == '3° Año') ? 'selected' : ''; ?>>3° Año</option>
                            </select>

                            <label for="plan_estudio">Plan de Estudio:</label>
                            <select name="plan_estudio" id="plan_estudio" class="form-control" autocomplete="off" required>
                                <option value="" disabled>Seleccione el Plan de Estudio</option>
                                <option value="1° Cuatrimestre" <?php echo ($consulta_materias['plan_estudio'] == '1° Cuatrimestre') ? 'selected' : ''; ?>>1° Cuatrimestre</option>
                                <option value="2° Cuatrimestre" <?php echo ($consulta_materias['plan_estudio'] == '2° Cuatrimestre') ? 'selected' : ''; ?>>2° Cuatrimestre</option>
                                <option value="Anual" <?php echo ($consulta_materias['plan_estudio'] == 'Anual') ? 'selected' : ''; ?>>Anual</option>
                            </select>

                            <label for="id_tipo">Tipo:</label>
                            <select name="id_tipo" id="id_tipo" class="form-control" autocomplete="off" required>
                                <?php foreach ($tipos as $tipo): ?>
                                    <option value="<?php echo $tipo['id_tipo']; ?>" <?php echo ($consulta_materias['id_tipo'] == $tipo['id_tipo']) ? 'selected' : ''; ?>>
                                        <?php echo $tipo['nombre_tipo']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <label for="correlativas">Correlativas:</label>
                            <div class="form-group">
                                <?php foreach ($materias_agrupadas as $año => $planes): ?>
                                    <h6><?php echo htmlspecialchars($año); ?>:</h6>
                                    <?php foreach ($planes as $plan => $materias): ?>
                                        <h7><?php echo htmlspecialchars($plan); ?>:</h7>
                                        <?php foreach ($materias as $materia): ?>
                                            <?php if ($materia['id_materia'] != $materia_actual['id_materia']): ?>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" name="correlativas[]" value="<?php echo $materia['id_materia']; ?>" <?php echo (in_array($materia['id_materia'], $correlativas_actuales)) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label"><?php echo htmlspecialchars($materia['Nombre']); ?></label>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </div>

                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>
