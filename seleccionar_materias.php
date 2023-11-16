<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Selección de Materias</title>
</head>

<body>
    <?php require 'navbar.php'; ?>
    <section class="content mt-2">
        <div class="row m-auto ">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <div class="card-header bg-dark text-white pb-0">
                        <h5 class="d-inline-block ">Listado de Materias y Correlativas</h5>
                        <a class="btn btn-primary float-right mb-2" href="registromateria.php">Registro de Materia</a>
                    </div>
                    <h2>Selección de Materias</h2>
                    <form action="insertar.php" method="post">
                        <?php
                        // Verificar si se enviaron datos por el formulario de la página anterior
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_persona'])) {
                            // Obtener los ID de los alumnos seleccionados
                            $id_personas = $_POST['id_persona'];

                            // Conexión a la base de datos (reemplaza estos valores con los tuyos)
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "vidasilvestre";

                            // Crear conexión
                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // Verificar la conexión
                            if ($conn->connect_error) {
                                die("Conexión fallida: " . $conn->connect_error);
                            }

                            // Mostrar los datos de los alumnos seleccionados
                            echo "<h3>Alumnos Seleccionados:</h3>";
                            echo "<ul>";
                            foreach ($id_personas as $id_persona) {
                                // Query para obtener datos del alumno
                                $query_alumno = "SELECT nombre, apellido FROM persona WHERE id_persona = '$id_persona'";
                                $result_alumno = $conn->query($query_alumno);

                                if ($result_alumno->num_rows > 0) {
                                    $row = $result_alumno->fetch_assoc();
                                    echo "<li>{$row['nombre']} {$row['apellido']}</li>";
                                }
                            }
                            echo "</ul>";

                            // Mostrar la lista de materias disponibles
                            echo "<h3>Selección de Materias:</h3>";
                            echo "<table border='1'>";
                            echo "<tr>
                            <th>Seleccionar</th>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Descripción</th></tr>";

                            // Query para obtener materias con estado activo
                            $query_materias = "SELECT id_materia, Nombre, estado, descripcion FROM materia WHERE estado = 'Activo'";
                            $result_materias = $conn->query($query_materias);

                            while ($row = $result_materias->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td><input type='checkbox' name='id_materia[]' value='{$row['id_materia']}'></td>";
                                echo "<td>{$row['id_materia']}</td>";
                                echo "<td>{$row['Nombre']}</td>";
                                echo "<td>{$row['estado']}</td>";
                                echo "<td>{$row['descripcion']}</td>";
                                echo "</tr>";
                            }

                            echo "</table>";
                            echo "<input type='hidden' name='id_persona' value='" . implode(",", $id_personas) . "'>";
                            echo "<input type='submit' value='Inscribir'>";
                            echo "<input type='submit' name='accion' value='Cancelar'>";
                            echo "</form>";  // Cierre del formulario

                            // Cerrar la conexión
                            $conn->close();
                        } else {
                            // Si alguien intenta acceder a este archivo directamente sin enviar datos por el formulario
                            echo "Acceso no permitido.";
                        }
                        ?>
                    </form>
                    
                </div>
            </div>
        </div>
    </section>
</body>

</html>