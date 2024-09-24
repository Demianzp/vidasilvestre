<?php
require '../../conn/connection.php';
//-------------BORRADO------------------ 
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $db->prepare("UPDATE persona SET estado = 'Inactivo' WHERE id_persona = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $mensaje = "Registro Profesor Eliminado";
    header("Location:profe_index.php?mensaje=" . $mensaje);
}
?>
<!-- ------------------------------------------ -->
<?php require 'navbar.php'; ?>
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">
                    <!-- Usamos d-flex para alinear en una sola fila -->
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <h5 class="mb-0">Listado de Profesores</h5>
                        <!-- Contenedor para los botones -->
                        <div class="d-flex flex-wrap">
                            <a class="btn btn-warning me-2 mb-2" href="asigna_index.php">Listar Asignaciones</a>
                            <a class="btn btn-primary mb-2" href="profe_crea.php">Agregar Profesor</a>
                        </div>
                    </div>
                </div>


                <div class="card-body table-responsive">
                    <!-- <button type="submit" class="btn btn-primary">Buscar</button> ------->
                    <table id="example" class="table table-striped table-sm" style="width:100%">
                        <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
							<th>Apellido y Nombre</th>
                            <th>DNI</th>
							<th>Contacto</th>
						
                            <th><center>Acciones</center></th>
                        </thead>
                        <tbody>
                            <?php
                            // require 'conn/connection.php';
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
                                        <td><?php echo $profesor['apellido'] ?><?php echo $profesor['nombre'] ?></td>
                                        <td><?php echo $profesor['DNI'] ?></td>
                                  <td><i class="fa-solid fa-envelope"></i>  <?php echo $profesor['email_correo'];?><br>
    
                                  <i class="fa-solid fa-mobile-retro"></i>    <?php echo $profesor['celular'];?></td>
                                        <!-- <td></td> -->
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="asigna_crea.php?id=<?php echo $profesor['id_persona']; ?>" class="btn btn-info btn-sm" title="Asignar" role="button">Asignar</a>
                                                <a href="profe_edit.php?id=<?php echo $profesor['id_persona']; ?>" class="btn btn-warning btn-sm" title="Editar" role="button">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="javascript:eliminar2(<?php echo $profesor['id_persona']; ?>)" class="btn btn-danger btn-sm" title="Borrar" role="button">
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
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="js/ocultarMensaje.js"></script>
<?php require 'footer.php'; ?>