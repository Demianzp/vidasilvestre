<?php
require '../../conn/connection.php';
$mensaje = "";
$error = "";

if (!$db) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $presidente = isset($_POST['presidente']) ? $_POST['presidente'] : '';
    $primer = isset($_POST['primer']) ? $_POST['primer'] : '';
    $segundo = isset($_POST['segundo']) ? $_POST['segundo'] : '';
    $fecha_1 = $_POST['fecha_1'];
    $fecha_2 = $_POST['fecha_2'];
    $observacion = $_POST['observacion'];

    if (empty($presidente)) {
        $error = "El campo 'presidente' no puede estar vacío.";
    } else {
        try {
            $stmt = $db->prepare("INSERT INTO tribunal (presidente, primer, segundo, fecha_1, fecha_2, observacion) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $presidente);
            $stmt->bindParam(2, $primer);
            $stmt->bindParam(3, $segundo);
            $stmt->bindParam(4, $fecha_1);
            $stmt->bindParam(5, $fecha_2);
            $stmt->bindParam(6, $observacion);
            if ($stmt->execute()) {
                $mensaje = 'Registro cargado correctamente.';
            } else {
                $error = 'Error al cargar el registro: ' . implode(', ', $stmt->errorInfo());
            }
        } catch (PDOException $e) {
            $error = "Error en la conexión o consulta: " . $e->getMessage();
        }
    }
}

if ($mensaje || $error) {
    header("Location: listadomesa.php?mensaje=" . urlencode($mensaje) . "&error=" . urlencode($error));
    exit();
}
?>

<?php require 'navbar.php'; ?>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
     <!-- tribunales -->
        <div class="card rounded-2 border-0">
                <h5 class="card-header bg-dark text-white text-center">Tribunales</h5>
                <div class="card-body bg-light">
                    <form action="" method="post">
                        <div class="form-group mb-3">
                            <label for="presidente">Presidente de mesa:</label>
                                   <select name="presidente" autocomplete="off" class="form-control"  placeholder="Ingrese Nombre" required>
                                    <option disabled selected hidden>Seleccione el presidente</option>
                                    <?php
                                    $sql = $conexion->query("SELECT * FROM persona WHERE id_rol = 2 AND estado = 'Activo'");
                                    while ($resultado = $sql->fetch_assoc()) {
                                        echo "<option value='" . $resultado["nombre"] . " " . $resultado["apellido"] . "'>" . $resultado["nombre"] . " " . $resultado["apellido"] . "</option>";
                                    }
                                    ?>
                                </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="primer">Primer vocal:</label> 
                            <select name="primer" autocomplete="off" class="form-control"  placeholder="Ingrese Nombre" >
                                    <option disabled selected hidden>Seleccione el primer vocal</option>
                                    <?php
                                    $sql1 = $conexion->query("SELECT * FROM persona WHERE id_rol = 2 AND estado = 'Activo'");
                                    while ($resultado1 = $sql1->fetch_assoc()) {
                                        echo "<option value='" . $resultado1["nombre"] . " " . $resultado1["apellido"] . "'>" . $resultado1["nombre"] . " " . $resultado1["apellido"] . "</option>";
                                    }
                                    ?>
                                </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="segundo">Segundo vocal:</label> 
                            <select name="segundo" autocomplete="off" class="form-control"  placeholder="Ingrese Nombre">
                                    <option disabled selected hidden>Seleccione el segundo vocal</option>
                                    <?php
                                    $sql2 = $conexion->query("SELECT * FROM persona WHERE id_rol = 2 AND estado = 'Activo'");
                                    while ($resultado2 = $sql2->fetch_assoc()) {
                                        echo "<option value='" . $resultado2["nombre"] . " " . $resultado2["apellido"] . "'>" . $resultado2["nombre"] . " " . $resultado2["apellido"] . "</option>";
                                    }
                                    ?>
                                </select>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="fecha_1">Fecha Inicio:</label>
                                <input type="date" name="fecha_1" autocomplete="off" class="form-control" required>
                            </div>
                            <div class="form-group col-sm-12 col-md-6 mb-3">
                                <label for="fecha_2">Fecha Fin:</label>
                                <input type="date" name="fecha_2" autocomplete="off" class="form-control" required>
                            </div>
                        </div>

                        <div class="row">
                        
                        <div class="form-group mb-3">
                            <label for="observacion">Observación:</label>
                            <input type="text" name="observacion" autocomplete="off" class="form-control" placeholder="Ingrese observación" >
                        </div>
                        </div>
                        <input type="submit" class="btn btn-primary w-100" value="Agregar Tribunal">
                    </form>
                </div>
            </div>
           
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>
