<?php
require 'conn/connection.php';

// Consulta de Ciclos Lectivos
$ciclos = $db->prepare("SELECT * FROM ciclo_lectivo");
$ciclos->execute();
$ciclos = $ciclos->fetchAll();

// Consulta de Materias (se ha movido fuera del bloque if)
$materias = $db->prepare("SELECT * FROM materia");
$materias->execute();
$materias = $materias->fetchAll();

// Inicializar $alumnos como un array vacío
$alumnos = [];

// Procesamiento del formulario
if (isset($_GET['revisar'])) {
    // Obtener datos del formulario
    $id_materia = $_GET['materia'];
    $id_ciclo = $_GET['ciclo'];

    $sqlAlumnos = $db->prepare("SELECT a.id_persona, a.apellido, a.nombre, b.nota, AVG(b.nota) AS promedio
    FROM persona AS a
    LEFT JOIN acta AS b ON a.id_persona = b.id_persona
    LEFT JOIN mesa_examen AS me ON b.id_mesa = me.id_mesa
    WHERE a.id_rol = 1 AND a.id_ciclo_lectivo = :id_ciclo
    GROUP BY a.id_persona, a.apellido, a.nombre");

    $id_ciclo = 1; // Reemplaza con el valor que necesites
    $id_materia = 1; // Reemplaza con el valor que necesites

    try {
        $sqlAlumnos->bindParam(':id_ciclo', $id_ciclo, PDO::PARAM_INT);
        $sqlAlumnos->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
        $sqlAlumnos->execute();

        $alumnos = $sqlAlumnos->fetchAll(PDO::FETCH_ASSOC);

        foreach ($alumnos as $alumno) {
            echo $alumno['apellido'] . ', ' . $alumno['nombre'] . '<br>';
            // Puedes imprimir más detalles sobre el alumno, como la nota y el promedio
        }
    } catch (PDOException $e) {
        echo 'Error al ejecutar la consulta: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Notas | Registro de Notas</title>
    <meta name="description" content="Registro de Notas del Centro Escolar" />
</head>

<body>
    <?php require 'navbar.php'; ?>

    <div class="container m-2 mt-3">
        <div class="row m-auto d-flex justify-content-center">
            <div class="col-auto">
                <div class="card rounded-2 border-0">
                    <div class="card-header bg-dark text-white">
                        <div class="d-inline-block">
                            <h5>Registro y Modificación Notas</h5>
                        </div>
                    </div>

                    <div class="card-body table-responsive-xl mb-1">
                        <?php
                        if (!isset($_GET['revisar'])) {
                        ?>
                            <form method="get" action="notas.view.php">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <label class="font-weight-bold">Seleccione la Materia</label><br>
                                        <select class="form-select" name="materia" required>
                                            <?php foreach ($materias as $materia) : ?>
                                                <option value="<?php echo $materia['id_materia'] ?>"><?php echo $materia['nombre'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                    <li class="list-group-item">
                                        <label for="ciclo">Ciclo Lectivo:</label>
                                        <select class="form-select" name="ciclo" required>
                                            <?php foreach ($ciclos as $ciclo) : ?>
                                                <option value="<?php echo $ciclo['id_ciclo_lectivo'] ?>"><?php echo $ciclo['nombre_ciclo_lectivo'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                </ul>

                                <br />

                                <div class="d-inline-block d-flex justify-content-center">
                                    <button type="submit" name="revisar" class="btn btn-primary" value="1">Ingresar Notas</button>
                                    <a class="btn btn-warning ml-3" href="listadonotas.view.php">Consultar Notas</a>
                                </div>
                            </form>
                        <?php
                        }
                        ?>

                        <?php
                        if (isset($_GET['revisar'])) {
                        ?>
                            <a class="btn btn-primary mb-2" href="notas.view.php"><strong>&lt;&lt; Volver</strong></a>
                            <div class="ml-3 mb-3" style="float: right">
                                <!-- Aquí deberías colocar la acción y el método correctos para el formulario -->
                                <form action="procesarnota.php" method="post">
                                    <button type="submit" class="btn btn-primary mr-2" name="insertar">Guardar</button>
                                    <a class="btn btn-warning" href="listadonotas.view.php">Consultar Notas</a>
                                </form>
                            </div>

                            <form action="procesarnota.php" method="post">
                                <table class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <th>#</th>
                                        <th>Apellidos</th>
                                        <th>Nombres</th>
                                        <th>Nota</th>
                                        <th>Promedio</th>
                                    </thead>

                                    <?php foreach ($alumnos as $index => $alumno) : ?>
                                        <tr>
                                            <td scope="row"><?php echo $alumno['id_persona'] ?></td>
                                            <td><?php echo $alumno['apellido'] ?></td>
                                            <td><?php echo $alumno['nombre'] ?></td>
                                            <td><input type="text" class="form-control" name="nota_<?php echo $index ?>" value="<?php echo $alumno['nota'] ?>"></td>
                                            <td><?php echo number_format($alumno['promedio'], 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </form>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require 'footer.php'; ?>
</body>

</html>
