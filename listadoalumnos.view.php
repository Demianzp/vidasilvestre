<!-- <!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Alumnos | Editar y Eliminar</title>
    <meta name="description" content="Registro de Notas del Centro Escolar">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head> -->
<?php require 'navbar.php'; ?>
<body>    
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
                    <!-- Mensaje de carga o error de alumno Modificar -->
                    <?php
                    if (!empty($infoMessage)) {
                        echo '<div class="alert alert-success" role="alert">' . htmlspecialchars($infoMessage) . '</div>';
                    }
                    if (!empty($errorMessage)) {
                        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($errorMessage)  . '</div>';
                    }
                    ?>
                    <!-- ---------------Mensaje de Persona desactiva o error --------------->
                    <?php
                    if (isset($_GET['inMessage']) && !empty($_GET['inMessage'])) {
                        echo '<div class="alert alert-success"role="alert">' . htmlspecialchars($_GET['inMessage']) . '</div>';
                    }
                    if (isset($_GET['errMessage']) && !empty($_GET['errMessage'])) {
                        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['errMessage']) . '</div>';
                    }
                    ?>
                    <!-- -------------------- -->
                    <div class="card-body table-responsive">
                        <form id="inscripcionForm" action="" method="post">
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
                                    <th>Historial</th>
                                    <th>Acciones</th>
                                                                        
                                                                       
                                </thead>
                                <tbody>
                                    <?php
                                    require 'conn/connection.php';
                                    try {
                                        $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
                                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $query = "SELECT * FROM persona WHERE id_rol = 1 AND estado = 'Activo'";
                                        $stmt = $db->prepare($query);
                                        $stmt->execute();
                                        $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($alumnos as $alumno) {
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo $alumno['id_persona'] ?></th>
                                                <td><?php echo $alumno['apellido'] ?></td>
                                                <td><?php echo $alumno['nombre'] ?></td>
                                                <td><?php echo $alumno['genero'] ?></td>
                                                <td><?php echo $alumno['DNI'] ?></td>
                                                <td><?php echo $alumno['fecha_ingreso'] ?></td>
                                                <td><?php echo $alumno['fecha_nacimiento'] ?></td>
                                                <td><?php echo $alumno['celular'] ?></td>
                                                <td><?php echo $alumno['ciudad'] ?></td>                                                
                                                <td><a href="" class="btn btn-info" type="button">Historial</a></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="" class="btn btn-primary btn-flat view_result" type="button">
                                                            <i class="fas fa-eye"></i>                                                        
                                                        </a>                                                
                                                    
                                                        <a href="alumnoedit.view.php?id=<?php echo $alumno['id_persona'] ?>" class="btn btn-warning " type="button">
                                                            <i class="fas fa-edit"></i>
                                                        </a>                                                
                                                    
                                                        <a href="alumnodelete.php?id=<?php echo $alumno['id_persona'] ?>" class="btn btn-danger " type="button">
                                                            <i class="fas fa-trash"></i>
                                                        </a> 
                                                    </div>  

                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    } catch (PDOException $e) {
                                        echo "Error de conexión: " . $e->getMessage();
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>
                        <br>
                        <br><br>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require 'footer.php'; ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/ocultarMensaje.js"></script>
</html>