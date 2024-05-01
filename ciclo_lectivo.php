<?php
require 'conn/connection.php'; // Incluye tu archivo de configuración de conexión a la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ciclo = $_POST['ciclo'];
    $fecha_inicio = $_POST['fecha'];
    $fecha_fin = $_POST['fecha_fin'];
    // Verifica que los campos no estén vacíos
    if (empty($ciclo) || empty($fecha_inicio) || empty($fecha_fin)) {
        echo "Error: Todos los campos son requeridos.";
    } else {
        $estado = "Activo";
        // Verifica si el ciclo lectivo ya existe en la base de datos
        $stmt = $db->prepare("SELECT COUNT(*) AS count FROM ciclo_lectivo WHERE nombre_ciclo = ?");
        $stmt->bindParam(1, $ciclo);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result['count'] > 0) {
            echo "Error: El ciclo lectivo ya está agregado.";
        } else {
            // Inserta el ciclo lectivo en la base de datos
            try {
                $stmt = $db->prepare("INSERT INTO ciclo_lectivo (nombre_ciclo, fecha_inicio, fecha_fin, Estado) VALUES (?, ?, ?, ?)");
                $stmt->bindParam(1, $ciclo);
                $stmt->bindParam(2, $fecha_inicio);
                $stmt->bindParam(3, $fecha_fin);
                $stmt->bindParam(4, $estado);
                $stmt->execute();
                echo "Ciclo Lectivo agregado exitosamente.";
            } catch (PDOException $e) {
                echo "Error al agregar el ciclo lectivo: " . $e->getMessage();
            }
        }
    }
}
?>
<!-- ------------------------------------------------------------ -->
<?php require 'navbar.php'; ?>
    <div class="container mt-3 " style="width: 40rem">
        <div class="row d-flex justify-content-center ">
            <div class="col ">
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white">Agregar Ciclo Lectivo</h5>
                    <div class="card-body bg-light">
                        <form action="ciclo_lectivo.php" method="post">
                            <div class="form-group">
                                <label for="ciclo">Ingrese Ciclo:</label>
                                <input type="text" class="form-control" data-name="ciclo" name="ciclo" id="ciclo" placeholder="Ingrese Ciclo Lectivo" required autocomplete="off">
                            </div>
                            <!-- ---------------------------- -->
                            <div class="form-group">
                                <label for="fecha">Fecha Inicio:</label>
                                <input type="date" name="fecha" autocomplete="off" class="form-control" required>

                            </div>
                            <!-- ---------------------------- -->
                            <div class="form-group">
                                <label for="fecha_fin">Fecha Fin:</label>
                                <input type="date" name="fecha_fin" autocomplete="off" class="form-control" required>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-primary" value="Enviar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require 'footer.php'; ?>