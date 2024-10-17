<?php
require '../../conn/connection.php';
$mensaje = "";
$error = "";
// Realizar la consulta SQL para obtener las materias
$query = "SELECT id_materia, Nombre FROM materia WHERE estado = 'Activo'";
$result_materias = $db->query($query);
// Consulta SQL para obtener los ciclos lectivos
$query_ciclos = "SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo";
$result_ciclos = $db->query($query_ciclos);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila los datos del formulario
    $id_materia = $_POST['materia'];
    $nombre_mesa = isset($_POST['nombre_mesa']) ? $_POST['nombre_mesa'] : '';
    $fecha = $_POST['fecha'];
    $libro = $_POST['libro'];
    $folio = $_POST['folio'];
    $hora = $_POST['hora'];
    $id_tipo = $_POST['id_tipo'];
    $id_t = $_POST['tribunal'];
    $ciclo_lectivo = $_POST['ciclo_lectivo'];
    $estado = "Activo";

    // Verifica que el campo 'nombre_mesa' no sea nulo
    if (empty($nombre_mesa)) {
        $error = "El campo 'nombre_mesa' no puede estar vacío.";
    } else {
        // Inserta la mesa de examen en la base de datos
        try {
            $stmt = $db->prepare("INSERT INTO mesa_examen (nombre_mesa, id_materia, id_ciclo, fecha, folio, hora, estado, id_tipo, libro, id_t) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $nombre_mesa);
            $stmt->bindParam(2, $id_materia);
            $stmt->bindParam(3, $ciclo_lectivo);
            $stmt->bindParam(4, $fecha);
            $stmt->bindParam(5, $folio);
            $stmt->bindParam(6, $hora);
            $stmt->bindParam(7, $estado);
            $stmt->bindParam(8, $id_tipo);
            $stmt->bindParam(9, $libro);
            $stmt->bindParam(10, $id_t);
            if ($stmt->execute()) {
                $mensaje = 'Registro cargado correctamente.';
            } else {
                $error = 'Error al a cargar el registro: ' . implode(', ', $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            $error = "Error en la conexión o consulta: " . $e->getMessage();
        }
    }
}
// Redirigir solo si hay mensajes para enviar
if ($mensaje || $error) {
    header("Location: mesa_alumno.php?mensaje=" . urlencode($mensaje) . "&error=" . urlencode($error));
    exit();
}
?>
<?php require 'navbar.php'; ?>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card rounded-2 border-0">
                <h5 class="card-header bg-dark text-white text-center">Agregar Mesa de Examen</h5>
                <div class="card-body bg-light">
                    <form action="" method="post">
                        <div class="form-group mb-3">
                            <label for="nombre_mesa">Nombre de Mesa:</label>
                            <input type="text" name="nombre_mesa" autocomplete="off" class="form-control" placeholder="Ingrese Nombre" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="materia">Materia:</label>
                            <select name="materia" id="materia" class="form-control" autocomplete="off" required>
                                <option value="" hidden disabled selected>Elija la materia</option>
                                <?php
                                require '../../conn/connection.php';
                                $query = "SELECT id_materia, Nombre FROM materia WHERE estado = 'Activo'";
                                $result_materias = $db->query($query);
                                while ($row = $result_materias->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row['id_materia'] . "'>" . $row['Nombre'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="id_tipo">Tipo de Mesa:</label>
                            <select name="id_tipo" class="form-control" autocomplete="off" required>
                                <option value="" hidden disabled selected>Seleccione su Tipo</option>
                                <option value="1">Regular</option>
                                <option value="3">Libre</option>
                            </select>
                        </div>

                        
                        <div class="form-group mb-3">
                                <label for="fecha">Fecha:</label>
                                <input type="date" name="fecha" autocomplete="off" class="form-control" required>
                            </div>
                    

                        <div class="row">
                        <div class="form-group col-sm-12 col-md-6 mb-3">
                            <label for="hora">Hora:</label>
                            <input type="time" name="hora" autocomplete="off" class="form-control" required>
                        </div>

                        <div class="form-group col-sm-12 col-md-6 mb-3">
                            <label for="ciclo_lectivo">Ciclo Lectivo:</label>
                            <select name="ciclo_lectivo" id="ciclo_lectivo" class="form-control" autocomplete="off" required>
                                <option value="" disabled selected>Seleccione el ciclo lectivo</option>
                                <?php
                                require '../../conn/connection.php';
                                $query_ciclos = "SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo";
                                $result_ciclos = $db->query($query_ciclos);
                                while ($row_ciclo = $result_ciclos->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $row_ciclo['id_ciclo'] . "'>" . $row_ciclo['nombre_ciclo'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="libro">Libro:</label>
                                <input type="number" name="libro" autocomplete="off" class="form-control" >
                            </div>
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="folio">Folio:</label>
                                <input type="number" name="folio" autocomplete="off" class="form-control" >
                            </div>
                        </div>
                       
                        </div>
                        <div class="form-group">
                                <label for="tribunal"><strong>Tribunal:</strong></label>
                                <select name="tribunal" class="form-control" >
                                    <option disabled selected hidden>Seleccione el tribunal</option>
                                    <?php
                                    $sqlt = $conexion->query("SELECT * FROM tribunal");
                                    while ($resultadot = $sqlt->fetch_assoc()) {
                                        echo "<option value='" . $resultadot["id_t"] . "'>" . $resultadot["presidente"] . " / " . $resultadot["fecha_1"] . " </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                      
                        <input type="submit" class="btn btn-primary w-100" value="Agregar Mesa">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>
