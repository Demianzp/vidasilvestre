<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Alumnos | Editar y Eliminar</title>
    <meta name="description" content="Registro de Notas del Centro Escolar">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php require 'navbar.php'; ?>
    <section class="content mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <div class="card-header pb-0 bg-dark text-white ">
                        <h5 class="d-inline-block ">Listado de Alumnos</h5>
                        <a class="btn btn-primary float-right mb-2" href="alumnos.view.php">Agregar Alumno</a>
                    </div>
                    
                    <?php
                    if (isset($_GET['mensaje']) && !empty($_GET['mensaje'])) {
                        echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($_GET['mensaje']) . '</div>';
                    }
                    if (isset($_GET['error']) && !empty($_GET['error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    ?> 
                    <h2>Selección de Alumnos</h2>
                    <form action="seleccionar_materias.php" method="post">
                        <label for="id_persona">Alumnos:</label>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <th>Seleccionar</th>
                                <th>ID</th>
                                <th>Apellidos</th>
                                <th>Nombres</th>
                                <th>Genero</th>
                                <th>DNI</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Celular</th>
                                <th>Departamento</th>
                            </thead>
                            <tbody>

                                <?php
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

                                // Query para obtener alumnos con id_rol=1 y estado activo
                                $query_alumnos = "SELECT id_persona, apellido, nombre, genero, dni, fecha_ingreso, fecha_nacimiento, celular, ciudad FROM persona WHERE id_rol = 1 AND estado = 'Activo'";
                                $result_alumnos = $conn->query($query_alumnos);

                                // Mostrar filas en la tabla para cada alumno
                                while ($alumno = $result_alumnos->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td><input type='checkbox' name='id_persona[]' value='" . $alumno['id_persona'] . "'></td>";
                                    echo "<td>" . $alumno['id_persona'] . "</td>";
                                    echo "<td>" . $alumno['apellido'] . "</td>";
                                    echo "<td>" . $alumno['nombre'] . "</td>";
                                    echo "<td>" . $alumno['genero'] . "</td>";
                                    echo "<td>" . $alumno['dni'] . "</td>";
                                    echo "<td>" . $alumno['fecha_ingreso'] . "</td>";
                                    echo "<td>" . $alumno['fecha_nacimiento'] . "</td>";
                                    echo "<td>" . $alumno['celular'] . "</td>";
                                    echo "<td>" . $alumno['ciudad'] . "</td>";
                                    echo "</tr>";
                                }

                                // Cerrar la conexión
                                $conn->close();
                                ?>
                            </tbody>


                        </table>

                        <input type="submit" value="Continuar">
                    </form>
                </div>
            </div>
        </div>
    </section>
    <?php require 'footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="js/ocultarMensaje.js"></script>

</html>