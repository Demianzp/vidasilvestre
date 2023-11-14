<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Profesores | Editar y Eliminar</title>
    <meta name="description" content="Registro de Notas del Centro Escolar">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <?php require 'navbar.php'; ?>
    <section class="content mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <div class="card-header bg-dark text-white pb-0">
                        <h5 class="d-inline-block">Listado de Profesores</h5>
                        <a class="btn btn-primary float-right mb-2" href="profesor.php">Agregar Profesor</a>
                        <!-- <form class="form-group mx-sm-3 d-inline-block">
                            <input class="form-control  light-table-filter" data-table="table_id" type="text" placeholder="Buscar ">
                        </form> -->
                    </div>
                   <!-- Mensaje de carga o error de alumno Cargar -->
                   <?php
                    if (isset($_GET['mensaje']) && !empty($_GET['mensaje'])) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['mensaje']) . '</div>';
                    }
                    if (isset($_GET['error']) && !empty($_GET['error'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    ?>

                    <!-- Mensaje de carga o error de alumno Modificar -->
                    <?php
                    if (!empty($infoMessage)) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($infoMessage) . '</div>';
                    }
                    if (!empty($errorMessage)) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($errorMessage) . '</div>';
                    }
                    ?>

                    <!---------------Mensaje de Persona desactiva o error --------------------------------->
                    <?php
                    if (isset($_GET['inMessage']) && !empty($_GET['inMessage'])) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['inMessage']) . '</div>';
                    }
                    if (isset($_GET['errMessage']) && !empty($_GET['errMessage'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['errMessage']) . '</div>';
                    }
                    ?>
                    <div class="card-body table-responsive">
                        <!-- <button type="submit" class="btn btn-primary">Buscar</button> ------->
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <th>#</th>
                                <th>Apellidos</th>
                                <th>Nombres</th>
                                <th>Genero</th>
                                <th>DNI</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Celular</th>
                                <th>Departamento</th>
                                <th>Asignar</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </thead>
                            <tbody>
                                <?php
                                require 'conn/connection.php';
                                try {
                                    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
                                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $query = "SELECT * FROM persona WHERE id_rol = 2 AND estado = 'Activo'";
                                    $stmt = $db->prepare($query);
                                    $stmt->execute();
                                    $profesores = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($profesores as $profesor) {
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $profesor['id_persona'] ?></th>
                                            <td><?php echo $profesor['apellido'] ?></td>
                                            <td><?php echo $profesor['nombre'] ?></td>
                                            <td><?php echo $profesor['genero'] ?></td>
                                            <td><?php echo $profesor['DNI'] ?></td>
                                            <td><?php echo $profesor['fecha_ingreso'] ?></td>
                                            <td><?php echo $profesor['fecha_nacimiento'] ?></td>
                                            <td><?php echo $profesor['celular'] ?></td>

                                            <td><?php echo $profesor['ciudad'] ?></td>
                                            <td><a href="asignar_F.php?id=<?php echo $profesor['id_persona'] ?>" class="btn btn-info" role="button">Asignar</a></td>
                                            <td><a href="editarprofe.php?id=<?php echo $profesor['id_persona'] ?>" class="btn btn-warning" role="button">Editar</a></td>
                                            <td><a href="deletprofe.php?id=<?php echo $profesor['id_persona'] ?>" class="btn btn-danger" role="button">Eliminar</a></td>
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script  src="js/ocultarMensaje.js"></script>
<!-- <script src="js/buscador.js"></script> -->
</html>