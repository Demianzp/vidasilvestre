<?php
require 'conn/connection.php';
$infoMessage = '';
$errorMessage = '';
// Verificar si la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si el campo 'id' está presente en el formulario
    if (isset($_POST['id'])) {
        // Obtener los datos del formulario
        $id_materia = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $horas = $_POST['horas'];
        $año = $_POST['año'];
        $num_resolucion = $_POST['num_resolucion'];
        $plan_estudio = $_POST['plan_estudio'];
        $id_tipo = $_POST['id_tipo'];

        $consulta_actualizar = $db->prepare("UPDATE materia SET nombre = ?, descripcion = ?, horas = ?, año = ?, num_resolucion = ?, plan_estudio = ?, id_tipo = ? WHERE id_materia = ?");

        // Ejecutar la consulta
        if ($consulta_actualizar->execute([$nombre, $descripcion, $horas, $año, $num_resolucion, $plan_estudio, $id_tipo, $id_materia])) {
            $infoMessage = 'Registro modificado correctamente';
        } else {
            $errorMessage = 'Error al editar el registro: ' . implode(', '. $consulta_actualizar->errorInfo());
        }
    } else {
        // Si el campo 'id' no está presente en el formulario
        $errorMessage = 'Falta el ID de la materia en el formulario.';
    }
}

// Verificar si se proporciona un ID válido en la URL
if (isset($_GET['id'])) {
    $id_materia = $_GET['id'];

    // Consultar la materia con el ID proporcionado
    $consulta_materia = $db->prepare("SELECT * FROM materia WHERE id_materia = ?");
    $consulta_materia->execute([$id_materia]);
    $materia = $consulta_materia->fetch();

    // Verificar si se encontró la materia
    if (!$materia) {
        die('No se encontró la materia con el ID proporcionado.');
    }
} else {
    // Si no se proporciona un ID válido en la URL
    die('Ha ocurrido un error');
}

// Redirigir solo si hay mensajes para enviar
if ($infoMessage || $errorMessage) {
    header("Location: listado_materia.php?mensaje=" . urlencode($infoMessage) . "&error=" . urlencode($errorMessage));
    exit();
}
?>

<!-- El resto del código HTML permanece sin cambios -->



<!-- El resto del código HTML permanece sin cambios -->



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de Materia</title>
    <meta name="description" content="Registro de Notas del Centro Escolar Materia Lennin" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoI6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crosigin="anonymous">
</head>

<body>
    <?php require 'navbar.php'; ?>

    <div class="container mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white">Edición de Materia</h5>
                    <div class="card-body bg-light">
                        <form method="post" class="form" action="">
                            <input type="hidden" class="form-control" name="id" value="<?php echo htmlspecialchars($materia['id_materia']); ?>">
                            <!-------------------------------------------------------------->
                            <label>Nombres:</label>
                            <input type="text" class="form-control" required name="nombre" autocomplete="off" value="<?php echo htmlspecialchars($materia['nombre']); ?>" maxlength="45">
                            <!-------------------------------------------------------------->
                            <label>Descripción:</label>
                            <input type text="text" class="form-control" required name="descripcion" autocomplete="off" value="<?php echo htmlspecialchars($materia['descripcion']); ?>" maxlength="45">
                            <!-------------------------------------------------------------->
                            <label>Horas de cursada:</label>
                            <input type="text" class="form-control" required name="horas" id="horas" autocomplete="off" value="<?php echo htmlspecialchars($materia['horas']); ?>" maxlength="8">
                            <span id="horasOK"></span>
                            <br>
                            <!-------------------------------------------------------------->
                            <label>Año de Cursado:</label>
                            <input type="text" class="form-control" required name="año" id="año" autocomplete="off" value="<?php echo htmlspecialchars($materia['año']); ?>" maxlength="45">
                            <span id="añoOK"></span>
                            <br>
                            <!-------------------------------------------------------------->
                            <label>Número de resolución:</label>
                            <input type="text" class="form-control" required name="num_resolucion" id="num_resolucion" autocomplete="off" value="<?php echo htmlspecialchars($materia['num_resolucion']); ?>" maxlength="10">
                            <span id="num_resolucionOK"></span>
                            <br>
                            <!-------------------------------------------------------------->
                            <label for="plan_estudio">Plan de Estudio</label>
                            <input type="text" class="form-control" data-name="Plan de Estudio" id="plan_estudio" name="plan_estudio" autocomplete="off" value="<?php echo htmlspecialchars($materia['plan_estudio']); ?>" maxlength="10">

                            <!-------------------------------------------------------------->
                            <div class="form-group">
                                <label for="id_tipo">Tipo de Materia:</label>
                                <select name="id_tipo" class="form-control" autocomplete="off" required>
                                    <option value="" disabled>Seleccione su Tipo</option>
                                    <option value="1" <?php echo ($materia['id_tipo'] == 1) ? 'selected' : ''; ?>>Regular</option>
                                    <option value="2" <?php echo ($materia['id_tipo'] == 2) ? 'selected' : ''; ?>>Promocional</option>
                                    <option value="3" <?php echo ($materia['id_tipo'] == 3) ? 'selected' : ''; ?>>Libre</option>
                                </select>
                            </div>

                            <!-------------------------------------------------------------->

                            <div class="mt-3 mb-2">
                                <button type="submit" class="btn btn-primary" name="modificar" onclick="return confirm('¿Estás seguro de guardar los cambios?')">Guardar Cambios</button>
                                <a class="btn btn-warning" href="listado_materia.php">Ver Listado</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require 'footer.php'; ?>
    <script src="js/contraseña.js"></script>
    <script src="js/validacion.js"></script>
    <script src="js/validacion2.js"></script>
</body>

</html>