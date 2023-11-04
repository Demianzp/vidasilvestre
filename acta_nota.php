<!DOCTYPE html>
<html>
<head>
    <title>Formulario para Acta</title>
</head>
<body>

<form action="procesar_acta.php" method="post">
    <label for="id_mesa">Mesa de Examen:</label>
    <select name="id_mesa" id="id_mesa">
        <?php
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "44061051";
        $database = "vida_silvestre";

        // Crear conexión
        $conn = new mysqli($servername, $username, $password, $database);

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta para obtener las mesas de examen disponibles
        $sql_mesas = "SELECT id_mesa, nombre_mesa, tipo FROM mesa_examen";
        $result_mesas = $conn->query($sql_mesas);

        if ($result_mesas->num_rows > 0) {
            while ($row = $result_mesas->fetch_assoc()) {
                echo "<option value='" . $row['id_mesa'] . "'>" . $row['nombre_mesa'] . $row['tipo']  . "</option>";
            }
        }
        ?>
    </select>
    <br><br>

    <label for="id_persona">Alumno:</label>
    <select name="id_persona" id="id_persona">
        <?php
        // Consulta para obtener personas con id_rol 1
        $sql_personas = "SELECT id_persona, nombre FROM persona WHERE id_rol = 1";
        $result_personas = $conn->query($sql_personas);

        if ($result_personas->num_rows > 0) {
            while ($row = $result_personas->fetch_assoc()) {
                echo "<option value='" . $row['id_persona'] . "'>" . $row['nombre'] . "</option>";
            }
        }

        // Cerrar la conexión a la base de datos
        $conn->close();
        ?>
    </select>
    <br><br>

    <div class="col">
                            <label for="nota">nota:</label>
                            <select name="nota" id="nota" class="form-control" autocomplete="off" required>
                                <option value="">seleccione una nota</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>

    <input type="submit" value="Enviar">
</form>

</body>
</html>
