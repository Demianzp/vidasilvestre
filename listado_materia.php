<?php require 'navbar.php'; ?>
<body>
    
    <section class="content mt-2">
        <div class="row m-auto ">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <div class="card-header bg-dark text-white pb-0">
                        <h5 class="d-inline-block ">Listado de Materias y Correlativas</h5>
                        <a class="btn btn-primary float-right mb-2" href="registromateria.php">Registro de Materia</a>
                    </div>
                    <!-- Mensaje de Cancrelacion -->
                    <?php
                    if (isset($_GET['mensajeCancelacion']) && !empty($_GET['mensajeCancelacion'])) {
                        $mensajeCancelacion = htmlspecialchars($_GET['mensajeCancelacion']);
                        echo '<div class="alert alert-warning" role="alert">' . $mensajeCancelacion . '</div>';
                    }
                    if (isset($_GET['mensaje']) && !empty($_GET['mensaje'])) {
                        echo '<div class="alert alert-success " role="alert">' . htmlspecialchars($_GET['mensaje']) . '</div>';
                    }
                    if (isset($_GET['error']) && !empty($_GET['error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    ?>
                    <!-- Mensaje de materia editada  -->
                    <?php
                    if (isset($_GET['infoMessage']) && !empty($_GET['infoMessage'])) {
                        echo '<div class="alert alert-success" role="alert">>' . htmlspecialchars($_GET['infoMessage']) . '</div>';
                    }
                    if (isset($_GET['errorMessage']) && !empty($_GET['errorMessage'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['errorMessage']) . '</div>';
                    }
                    ?>

                    <!---------------Mensaje de materia desactiva o error --------------------------------->
                    <?php
                    if (isset($_GET['inMessage']) && !empty($_GET['inMessage'])) {
                        echo '<div class="alert alert-success">' . htmlspecialchars($_GET['inMessage']) . '</div>';
                    }
                    if (isset($_GET['errMessage']) && !empty($_GET['errMessage'])) {
                        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['errMessage']) . '</div>';
                    }
                    ?>

                    <div class="card-body table-responsive">
                        <table id="example" class="table table-striped bg-dark" style="width:100%">
                            <thead class="thead-dark">
                                <th>ID Materia</th>
                                <th>Materia</th>
                                <th>ID Correlativa</th>
                                <th>Acciones</th>
                            </thead>
                            <tbody>
                                <?php
                                require 'conn/connection.php';
                                try {
                                    $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
                                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                    $query = "SELECT m.id_materia, m.Nombre AS 'Materia', c.id_correlativa, c.id_materia AS 'Correlativa'
                                        FROM materia m
                                        LEFT JOIN correlativa c ON m.id_materia = c.id_materia
                                        WHERE m.estado = 'Activo'";
                                    $stmt = $db->prepare($query);
                                    $stmt->execute();
                                    $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($materias as $materia) {
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $materia['id_materia'] ?></th>
                                            <td><?php echo $materia['Materia'] ?></td>
                                            <td><?php echo $materia['id_correlativa'] ?></td>

                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="materiaedit.php?id=<?php echo $materia['id_materia'] ?>" class="btn btn-warning" role="button">
                                                        <i class="fas fa-edit"></i>
                                                    </a>                                                
                                                    
                                                    <a href="materiadelet.php?id=<?php echo $materia['id_materia'] ?>" class="btn btn-danger" role="button">
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
</html>
