<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Materias y Correlativass</title>
</head>
<body>
    <?php require 'navbar.php'; ?>
    <section class="content mt-2">
        <div class="row m-auto ">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <div class="card-header bg-dark text-white pb-0">
                        <h5 class="d-inline-block ">Listado de Materias y Correlativas</h5>

                        <a class="btn btn-primary float-right" href="registromateria.php">Registro de Materia</a>
                        <form class="form-group mx-sm-3 d-inline-block">
                            <input class="form-control  light-table-filter" data-table="table_id" type="text" placeholder="Buscar ">
                        </form>

                    </div>
                    <?php
                    // Verificar si hay un mensaje en la URsL
                    if (isset($_GET['mensajeCancelacion']) && !empty($_GET['mensajeCancelacion'])) {
                        $mensajeCancelacion = htmlspecialchars($_GET['mensajeCancelacion']);
                        echo '<div class="alert alert-warning">' . $mensajeCancelacion . '</div>';
                    }
                        if (isset($_GET['mensaje']) && !empty($_GET['mensaje'])) {
                            echo '<div class="alert alert-success " role="alert">' . htmlspecialchars($_GET['mensaje']) . '</div>';
                        }
                        if (isset($_GET['error']) && !empty($_GET['error'])) {
                            echo '<div class="alert alert-danger"> role="alert"' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                    ?>
                    


                    <div class="card-body table-responsive">
                        <!-- <button type="submit" class="btn btn-primary">Buscar</button> -->
                        <table class="table table-bordered table-striped table_id">
                            <thead class="thead-dark">
                                <th>ID Materia</th>
                                <th>Materia</th>
                                <th>ID Correlativa</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </thead>
                            <tbody>
                                <?php
                                require 'conn/connection.php';
                                try {
                                    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
                                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $query = "SELECT m.id_materia, m.nombre AS 'Materia', c.id_correlativa, c.id_materia AS 'Correlativa'
                                        FROM materia m
                                        LEFT JOIN correlativa c ON m.id_materia = c.id_materia";
                                    $stmt = $db->prepare($query);
                                    $stmt->execute();
                                    $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($alumnos as $alumno) {
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $alumno['id_materia'] ?></th>
                                            <td><?php echo $alumno['Materia'] ?></td>
                                            <td><?php echo $alumno['id_correlativa'] ?></td>
                                            <td><a href="##editarmateria##?id=<?php echo $profesor['id_persona'] ?>" class="btn btn-warning" role="button">Editar</a></td>
                                            <td><a href="##eliminarmateria##?id=<?php echo $profesor['id_persona'] ?>" class="btn btn-danger" role="button">Eliminar</a></td>
                                        </tr>
                                <?php
                                    }
                                } catch (PDOException $e) {
                                    echo "Error de conexión: " . $e->getMessage();
                                }
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <br><br>
                        <!-- Mostrar mensajes que se reciben a través de los parámetros en la URL -->
                        <?php
                        if (isset($_GET['err'])) {
                            echo '<span class="error">Error al almacenar el registro</span>';
                        }
                        if (isset($_GET['info'])) {
                            echo '<span class="success">Registro almacenado correctamente!</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require 'footer.php'; ?>
</body>
<script src="js/buscador.js"></script>
<script src="js/mensaje_hidden.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</html>

