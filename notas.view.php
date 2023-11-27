<?php
require 'conn/connection.php';

// Consulta de Materias activas
$materias = $db->prepare("SELECT * FROM materia WHERE estado = 'Activo'");
$materias->execute();
$materias = $materias->fetchAll();

$ciclos = $db->prepare("SELECT * FROM ciclo_lectivo WHERE estado = 'Activo'");
$ciclos->execute();
$ciclos = $ciclos->fetchAll();

// Inicializar $alumnos como un array vacío
$alumnos = [];

// Procesamiento del formulario
if (isset($_GET['revisar'])) {
    $id_materia = $_GET['materia'];
    // Validar datos del formulario
    if (!is_numeric($id_materia)) {
        die('Error: Los datos del formulario no son válidos.');
    }
    $sqlAlumnos = $db->prepare("
        SELECT 
            a.id_persona, 
            CONCAT(a.apellido, ', ', a.nombre) AS nombre, 
            e.id_materia, 
            e.id_ciclo, 
            COALESCE(n.nota1, '') as nota1,
            COALESCE(n.nota2, '') as nota2,
            COALESCE(n.nota3, '') as nota3,
            COALESCE(n.nota4, '') as nota4,
            AVG((n.nota1 + n.nota2 + n.nota3 + n.nota4) / 4) AS promedio
        FROM 
            persona AS a
        LEFT JOIN 
            estadoalumno AS e ON a.id_persona = e.id_persona
        LEFT JOIN 
            nota AS n ON e.id_nota = n.id_nota
        WHERE 
            a.id_rol = 1 
            AND e.id_materia = :id_materia
        GROUP BY 
            a.id_persona, 
            a.apellido, 
            a.nombre, 
            e.id_materia, 
            e.id_ciclo, 
            n.nota1,
            n.nota2,
            n.nota3,
            n.nota4
    ");

    try {
        $sqlAlumnos->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
        $sqlAlumnos->execute();

        // Almacenar los resultados en la variable $alumnos
        $alumnos = $sqlAlumnos->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error al ejecutar la consulta: ' . $e->getMessage();
    }
}
?>
<!-- 
<!DOCTYPE html>
<html> -->

<!-- <head>
    <title>Notas | Registro de Notas</title>
    <meta name="description" content="Registro de Notas del Centro Escolar" />
</head> -->
<?php require 'navbar.php'; ?>

<body>

    <div class="container mt-3">
        <div class="row d-flex justify-content-center">
            <div class="col-auto">
                <div class="card rounded-2 border-0">
                    <div class="card-header bg-dark text-white">
                        <div class="content">
                            <h5 class="d-inline-block">Registro y Modificación Notas</h5>
                        </div>

                    </div>
                    <div class="card-body table-responsive-xl mb-1">
                        <?php if (!isset($_GET['revisar'])) { ?>
                            <form method="get" action="">
                                <label class="font-weight-bold">Seleccione la Materia</label><br>
                                <select class="form-select" name="materia" required>
                                    <option value="" disabled selected>Seleccione la Materia</option>
                                    <?php foreach ($materias as $materia) : ?>
                                        <option value="<?php echo $materia['id_materia'] ?>"><?php echo $materia['Nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <label class="font-weight-bold">Seleccione Ciclo</label><br>
                                <select name="ciclo_lectivo" id="ciclo_lectivo" class="form-control" autocomplete="off" required>
                                    <option value="" disabled selected>Seleccione el ciclo lectivo</option>
                                    <?php
                                    foreach ($ciclos as $ciclo) : ?>
                                        <option value="<?php echo $ciclo['id_ciclo'] ?>"><?php echo $ciclo['nombre_ciclo'] ?></option>
                                    <?php endforeach; ?>
                                    ?>
                                </select>


                                <div class="d-inline-block d-flex justify-content-center mt-3">
                                    <button type="submit" name="revisar" class="btn btn-primary" value="1">Ingresar Notas</button>
                                    <a class="btn btn-warning ml-3" href="listadonotas.view.php">Consultar Notas</a>
                                </div>
                            </form>
                        <?php } ?>

                        <?php if (isset($_GET['revisar'])) { ?>
                            <form action="guardar_notas.php" method="post">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <th width="20px">#</th>
                                        <th>Apellido y Nombre</th>
                                        <th width="20px">Nota1</th>
                                        <th width="20px">Nota2</th>
                                        <th width="20px">Nota3</th>
                                        <th width="20px">Nota4</th>
                                        <th>Calif. Regularidad</th>
                                    </thead>
                                    <?php foreach ($alumnos as $index => $alumno) : ?>
                                        <tr>
                                            <td scope="row" width="20px"><?php echo $alumno['id_persona'] ?></td>
                                            <td><?php echo $alumno['nombre'] ?></td>
                                            <td><input type="text" width="20px" class="form-control" placeholder="00.00" name="nota1_<?php echo $alumno['id_persona'] ?>" value="<?php echo $alumno['nota1'] ?>"></td>
                                            <td><input type="text" width="20px" class="form-control" placeholder="00.00" name="nota2_<?php echo $alumno['id_persona'] ?>" value="<?php echo $alumno['nota2'] ?>"></td>
                                            <td><input type="text" width="20px" class="form-control" placeholder="00.00" name="nota3_<?php echo $alumno['id_persona'] ?>" value="<?php echo $alumno['nota3'] ?>"></td>
                                            <td><input type="text" width="20px" class="form-control" placeholder="00.00" name="nota4_<?php echo $alumno['id_persona'] ?>" value="<?php echo $alumno['nota4'] ?>"></td>
                                            <td><?php echo number_format($alumno['promedio'], 2) ?></td>
                                            <input type="hidden" name="id_persona_<?php echo $alumno['id_persona'] ?>" value="<?php echo $alumno['id_persona'] ?>">
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                                <div class="content mt-3 ">
                                    <a class="btn btn-danger mb-2" href="notas.view.php"><strong>&lt;&lt; Volver</strong></a>
                                    <div class="ml-3 " style="float: right">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <a class="btn btn-warning" href="listadonotas.view.php">Consultar Notas</a>
                                    </div>
                                </div>
                            </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require 'footer.php'; ?>
</body>

</html>