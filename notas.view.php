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

    // Validar datos del formulario
    if (!is_numeric($id_materia) || !is_numeric($id_ciclo)) {
        die('Error: Los datos del formulario no son válidos.');
    }

    // Consulta SQL con consultas preparadas
    $sqlAlumnos = $db->prepare("SELECT a.id_persona, CONCAT(a.apellido, ', ', a.nombre) AS nombre_completo, b.nota1, b.nota2, b.nota, AVG(b.nota) AS promedio
    FROM persona AS a
    LEFT JOIN estadoalumno AS b ON a.id_persona = b.id_persona
    WHERE a.id_rol = 1 AND b.id_ciclo = :id_ciclo
    AND b.id_materia = :id_materia
    GROUP BY a.id_persona, a.apellido, a.nombre");

    try {
        $sqlAlumnos->bindParam(':id_ciclo', $id_ciclo, PDO::PARAM_INT);
        $sqlAlumnos->bindParam(':id_materia', $id_materia, PDO::PARAM_INT);
        $sqlAlumnos->execute();

        // Almacenar los resultados en la variable $alumnos
        $alumnos = $sqlAlumnos->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo 'Error al ejecutar la consulta: ' . $e->getMessage();
    }
}
?>

<!-- <!DOCTYPE html>
<html>

<head>
    <title>Notas | Registro de Notas</title>
    <meta name="description" content="Registro de Notas del Centro Escolar" />
</head> -->
<?php require 'navbar.php'; ?>
<body>   
    <div class="container mt-3" >
        <div class="row d-flex justify-content-center ">
            <div class="col-auto " >
                <div class="card rounded-2 border-0">
                    <div class="card-header bg-dark text-white">
                        <div class="content">
                            <h5 class="d-inline-block">Registro y Modificación Notas</h5>                            
                        </div>
                          (Mostrar las notas en el input)                      
                    </div>
                
                    <div class="card-body table-responsive-xl mb-1">
                        <?php
                        if (!isset($_GET['revisar'])) {
                        ?>
                            <form method="get" action="notas.view.php" >
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <label class="font-weight-bold">Seleccione la Materia</label><br>
                                        <select class="form-select" name="materia" required>
                                            <?php foreach ($materias as $materia) : ?>
                                                <option value="<?php echo $materia['id_materia'] ?>"><?php echo $materia['Nombre'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                    <li class="list-group-item">
                                        <label for="ciclo">Ciclo Lectivo:</label>
                                        <select class="form-select" name="ciclo" required>
                                            <?php foreach ($ciclos as $ciclo) : ?>
                                                <option value="<?php echo $ciclo['id_ciclo'] ?>"><?php echo $ciclo['nombre_ciclo'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                </ul>
                                <div class="d-inline-block d-flex justify-content-center mt-3">
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
                            <!-- ------------------------------------------------- -->
                            <form action="procesarnota.php" method="post">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead class="thead-dark">
                                        <th>#</th>
                                        <th>Apellido y Nombre</th>
                                        <th>Nota1</th>
                                        <th>Nota2</th>
                                        <th>Nota3</th>
                                        <th>Nota4</th>
                                        <th>Calif. Regularidad</th>
                                        <th>Calif. Final</th>
                                    </thead>
                                    <?php foreach ($alumnos as $index => $alumno) : ?>
                                        <tr>
                                            <td scope="row"><?php echo $alumno['id_persona'] ?></td>
                                            <td><?php echo $alumno['nombre_completo'] ?></td>
                                            <td><input type="text" class="form-control" name="nota1_<?php echo $index ?>" value="<?php echo $alumno['nota1'] ?>"></td>
                                            <td><input type="text" class="form-control" name="nota2_<?php echo $index ?>" value="<?php echo $alumno['nota2'] ?>"></td>
                                            <td><input type="text" class="form-control" name="nota3_" value=""></td>
                                            <td><input type="text" class="form-control" name="nota4_" value=""></td>
                                            <td><?php echo number_format($alumno['promedio'], 2) ?></td>
                                            <td><input type="text" class="form-control" name="nota_final_<?php echo $index ?>" value="<?php echo $alumno['nota'] ?>"></td>  
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            </form>
                            <div class="content mt-3 ">
                                <a class="btn btn-danger mb-2" href="notas.view.php"><strong>&lt;&lt; Volver</strong></a>
                                <div class="ml-3 " style="float: right">
                                    <!-- Aquí deberías colocar la acción y el método correctos para el formulario -->
                                    <form action="procesarnota.php" method="post">
                                        <button type="submit" class="btn btn-primary mr-2" name="insertar">Guardar</button>
                                        <a class="btn btn-warning" href="listadonotas.view.php">Consultar Notas</a>
                                    </form>
                                </div>                            
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php require 'footer.php'; ?>


