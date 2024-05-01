<?php require 'navbar.php'; ?>

   <section class="content mt-2">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <div class="card-header bg-dark text-white pb-0">
                        <h5 class="d-inline-block">Listado de Materias y Correlativas</h5>
                        <a class="btn btn-primary float-right mb-2" href="registromateria.php">Registro de Materia</a>
                    </div>
                    <!-- Mensajes de notificación -->
                    <?php
                    $messages = array(
                        'mensajeCancelacion', 'mensaje', 'error', 'infoMessage', 'errorMessage', 'inMessage', 'errMessage'
                    );
                    foreach ($messages as $messageKey) {
                        if (isset($_GET[$messageKey]) && !empty($_GET[$messageKey])) {
                            $message = htmlspecialchars($_GET[$messageKey]);
                            echo '<div class="alert alert-' . ($messageKey === 'error' || $messageKey === 'errorMessage' || $messageKey === 'errMessage' ? 'danger' : 'success') . '">' . $message . '</div>';
                        }
                    }
                    ?>
                    <div class="card-body table-responsive">
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID Materia</th>
                                    <th>Materia</th>
                                    <th>Agregar Correlativa</th>
                                    <th>Acciones</th>
                                    <th>Listado de Alumnos</th>
                                    <th>Ciclo Lectivo Actual</th>
                                </tr>
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
                                            <td><?php echo $materia['id_materia'] ?></td>
                                            <td><?php echo $materia['Materia'] ?></td>
                                            <td class="text-center"><a href="correlativas.php?id=<?php echo $materia['id_materia'] ?>" class="btn btn-success"><i class="fa-sharp fa-solid fa-folder-open"></i></a></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="materiaedit.php?id=<?php echo $materia['id_materia'] ?>" class="btn btn-warning" role="button"><i class="fas fa-edit"></i></a>
                                                    <a href="materiadelet.php?id=<?php echo $materia['id_materia'] ?>" class="btn btn-danger" role="button"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </td>
                                            <td class="text-center"><a href="materia_alumno.php?id=<?php echo $materia['id_materia'] ?>" class="btn btn-success">Listado de Alumnos</a></td>
                                            <td>**2024**</td>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script  src="js/ocultarMensaje.js"></script>
<?php require 'footer.php'; ?>   