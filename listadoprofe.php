
<?php require 'navbar.php'; ?>
<body>
    
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
                                <th>Acciones</th>
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
                                            
                                            <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="" class="btn btn-primary btn-flat view_result" type="button">
                                                            <i class="fas fa-eye"></i>                                                        
                                                        </a>                                                
                                                    
                                                        <a href="editarprofe.php?id=<?php echo $profesor['id_persona'] ?>" class="btn btn-warning" type="button">
                                                            <i class="fas fa-edit"></i>
                                                        </a>                                                
                                                    
                                                        <a href="deletprofe.php?id=<?php echo $profesor['id_persona'] ?>" class="btn btn-danger" type="button">
                                                            <i class="fas fa-trash"></i>
                                                        </a> 
                                                    </div>
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
    
</body>
<?php require 'footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script  src="js/ocultarMensaje.js"></script>
<!-- <script src="js/buscador.js"></script> -->
