<?php
require 'conn/connection.php';

$infoMessage = '';
$errorMessage = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id_materia= $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $horas = $_POST['horas'];
        $año = $_POST['año'];
        $num_resolucion = $_POST['num_resolucion'];
        $plan_estudio = $_POST['plan_estudio']; 
        $tipo = $_POST['tipo']; 
       
        $consulta_actualizar = $db->prepare("UPDATE materia SET nombre = :nombre, descripcion = :descripcion, horas = :horas, año = :año, num_resolucion = :num_resolucion, plan_estudio = :plan_estudio, Tipo = :tipo WHERE id_materia= :id");

        $consulta_actualizar->bindParam(':id', $id_materia, PDO::PARAM_INT);
        $consulta_actualizar->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $consulta_actualizar->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $consulta_actualizar->bindParam(':horas', $horas, PDO::PARAM_STR);
        $consulta_actualizar->bindParam(':año', $año, PDO::PARAM_STR);
        $consulta_actualizar->bindParam(':num_resolucion', $num_resolucion, PDO::PARAM_STR);
        $consulta_actualizar->bindParam(':plan_estudio', $plan_estudio, PDO::PARAM_STR);
        $consulta_actualizar->bindParam(':tipo', $tipo, PDO::PARAM_STR);
        

        if ($consulta_actualizar->execute()) {
            $infoMessage = 'Registro modificado correctamente';
        } else {
            $errorMessage = 'Error al editar el registro: ' . implode(', ', $consulta_actualizar->errorInfo());
        }
    } else {
        die('Falta el ID del materia en el formulario.');
    }
}
    
      
if (isset($_GET['id'])) {
    $id_materia = $_GET['id'];
    $consulta_materia = $db->prepare("SELECT * FROM materia WHERE id_materia = :id");
    $consulta_materia->bindParam(':id', $id_materia, PDO::PARAM_INT);
    $consulta_materia->execute();
    $materia = $consulta_materia->fetch();

    if (!$materia) {
        die('No se encontró el materias con el ID proporcionado.');
    }
} else {
    die('Ha ocurrido un error');
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de Materia</title>
    <meta name="description" content="Registro de Notas del Centro Escolar materia Lennin" />
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
                            <label>Descripcions:</label>
                            <input type text="text" class ="form-control" required name="descripcion" autocomplete="off" value="<?php echo htmlspecialchars($materia['descripcion']); ?>" maxlength="45">
                            <!-------------------------------------------------------------->
                            <label>Horas de cursada:</label>
                            <input type="text" class="form-control" required name="horas" id="horas" autocomplete="off" value="<?php echo htmlspecialchars($materia['horas']); ?>" maxlength="8">
                            <span id="horasOK"></span>
                            <br>
                            <!-------------------------------------------------------------->
                            <label>Año de Cursado:</label>
                            <input type="año" class="form-control" required name="año" id="año" autocomplete="off" value="<?php echo htmlspecialchars($materia['año']); ?>" maxlength="45">
                            <span id="añoOK"></span>
                            <br>
                            <!-------------------------------------------------------------->
                            <label>Número de resolución:</label>
                            <input type="tel" class="form-control" required name="num_resolucion" id="num_resolucion" autocomplete="off" value="<?php echo htmlspecialchars($materia['num_resolucion']); ?>" maxlength="10">
                            <span id="num_resolucionOK"></span>
                            <br>
                            <!-------------------------------------------------------------->                           
                            <label for="plan_estudio">Plan de Estudio</label>
                                <input type="text" class="form-control" data-name="Plan de Estudio" id="plan_estudio" name="plan_estudio"  autocomplete="off" value="<?php echo htmlspecialchars($materia['plan_estudio']); ?>" maxlength="10">
                           
                            <!-------------------------------------------------------------->
                            <label for="tipo">Tipo de Materia:</label>
                            <select class="form-control" name="tipo" id="tipo" value="<?php echo htmlspecialchars($materia['Tipo']); ?>" maxlength="10">
                            <option value="" >tipo</option>
                                    <option value="Anual">Anual</option>
                                    <option value="Cuatrimestral">Cuatrimestral</option>
                                    <option value="Trimestral">Trimestral</option>
                                </select>
                           
                            <!-------------------------------------------------------------->
                            
                            <div class="mt-3 mb-2">
                                <button type="submit" class="btn btn-primary" name="modificar" onclick="return confirm('¿Estás seguro de guardar los cambios?')">Guardar Cambios</button>
                                <a class="btn btn-warning" href="listado_materia.php">Ver Listado</a>
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
    <script src="js/contraseña.js"></script>
    <script src="js/validacion.js"></script>
    <script src="js/validacion2.js"></script>
</body>

</html>



