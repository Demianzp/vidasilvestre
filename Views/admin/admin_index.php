<?php
require '../../conn/connection.php';
if (isset($_POST['update'])) {
    $id_persona = $_POST['id_persona'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];

    try {
        $sql = "UPDATE persona SET 
                nombre = :nombre,
                apellido = :apellido,
                DNI = :dni,
                email_correo = :email
                WHERE id_persona = :id_persona";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':dni', $dni);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id_persona', $id_persona);
        if ($stmt->execute()) {
            header("Location: admin_index.php?mensaje=" . urlencode("Administrador actualizado con éxito."));
            exit();
        }
    } catch (PDOException $e) {
        header("Location: admin_index.php?error=" . urlencode("Error al actualizar: " . $e->getMessage()));
        exit();
    }
}
// Handle Delete
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $db->prepare("UPDATE persona SET estado = 'Inactivo' WHERE id_persona = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $mensaje = "Registro Administrador Eliminado";
    header("Location:admin_index.php?mensaje=" . $mensaje);
}
// Handle Create
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update'])) {
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $dni = $_POST["dni"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $estado = "Activo";
    $id_rol = "3";
    $pais = "Argentina";
    $error = "";
    try {
        // Check if email exists
        $sql_check_email = "SELECT COUNT(*) FROM persona WHERE email_correo = :email AND estado = 'Activo'";
        $stmt_check_email = $db->prepare($sql_check_email);
        $stmt_check_email->bindParam(':email', $email);
        $stmt_check_email->execute();
        $count = $stmt_check_email->fetchColumn();

        if ($count > 0) {
            $error = "El correo electrónico ya está registrado. Por favor, use uno diferente.";
            $redirect_url = "admin_index.php?error=" . urlencode($error)
                . "&nombre=" . urlencode($nombre)
                . "&apellido=" . urlencode($apellido)
                . "&email=" . urlencode($email);
            header("Location: " . $redirect_url);
            exit();
        } else {
            $sql = "INSERT INTO persona 
                    (nombre, apellido, DNI, email_correo, contraseña, id_rol, estado, fecha_ingreso, pais) 
                    VALUES 
                    (:nombre, :apellido, :dni, :email, :contrasena, :id_rol, :estado, NOW(), :pais)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':id_rol', $id_rol);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':pais', $pais);
            if ($stmt->execute()) {
                header("Location: admin_index.php?mensaje=" . urlencode("Administrador ingresado con éxito."));
                exit();
            }
        }
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
        header("Location: admin_index.php?error=" . urlencode($error));
        exit();
    }
}
?>
<!-- ------------------------- -->
<?php require 'navbar.php'; ?>
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="row">
                <div class="col">
                    <div class="card rounded-2 border-0 mb-3">
                        <h5 class="card-header bg-dark text-white">Lista de Administradores</h5>
                        <div class="card-body bg-light">
                            <form id="inscripcionForm" action="" method="post">
                                <table id="" class="table table-striped table-sm" style="width:100%">
                                    <thead class="thead-dark">
                                        <th>#</th>
                                        <th>Apellidos</th>
                                        <th>Nombres</th>
                                        <th>E-mail</th>
                                        <th>DNI</th>
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        try {
                                            $query = "SELECT * FROM persona WHERE id_rol = 3 AND estado = 'Activo'";
                                            $stmt = $db->prepare($query);
                                            $stmt->execute();
                                            $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($personas as $persona) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><?php echo $persona['id_persona'] ?></th>
                                                    <td><?php echo $persona['apellido'] ?></td>
                                                    <td><?php echo $persona['nombre'] ?></td>
                                                    <td><?php echo $persona['email_correo'] ?></td>
                                                    <td><?php echo $persona['DNI'] ?></td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <button onclick="editarAdmin(<?php echo $persona['id_persona']; ?>, 
                                                                '<?php echo $persona['nombre']; ?>', 
                                                                '<?php echo $persona['apellido']; ?>', 
                                                                '<?php echo $persona['DNI']; ?>', 
                                                                '<?php echo $persona['email_correo']; ?>')" 
                                                                class="btn btn-warning btn-sm" 
                                                                type="button" 
                                                                title="Editar">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <a href="javascript:eliminar4(<?php echo $persona['id_persona']; ?>)" 
                                                            class="btn btn-danger btn-sm" 
                                                            type="button" 
                                                            title="Borrar">
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
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-2 border-0">
                        <h5 class="card-header bg-dark text-white">Inscripción de Administrador</h5>
                        <div class="card-body bg-light">
                            <form id="formulario" action="" method="post">
                                <div id="parte1">
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" placeholder="Ingrese Nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido:</label>
                                        <input type="text" class="form-control" name="apellido" placeholder="Ingrese Apellido">
                                    </div>
                                    <div class="form-group">
                                        <label for="dni">DNI:</label>
                                        <input type="text" class="form-control" name="dni" id="dni" placeholder="Ingrese su DNI" >
                                        <span id="dniOK"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" name="email" id="email" autocomplete="off" placeholder="Ingrese su email" required>
                                        <span id="emailOK"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="contrasena">Contraseña:</label>
                                        <div class="input-group">
                                            <input class="form-control bg-light" type="password" placeholder="Contraseña" name="contrasena" id="contrasena" autocomplete="off" required />
                                            <button type="button" class="btn btn-outline-primary" name="toggle-eye" id="toggle-eye" onclick="togglePasswordVisibility()">
                                                <i class="fas fa-eye p-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal de Edición -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="editModalLabel">Editar Administrador</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="" method="post">
                    <input type="hidden" name="id_persona" id="edit_id_persona">
                    <input type="hidden" name="update" value="1">                    
                    <div class="form-group">
                        <label for="edit_nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="edit_nombre" required>
                    </div>                    
                    <div class="form-group">
                        <label for="edit_apellido">Apellido:</label>
                        <input type="text" class="form-control" name="apellido" id="edit_apellido" >
                    </div>                    
                    <div class="form-group">
                        <label for="edit_dni">DNI:</label>
                        <input type="text" class="form-control" name="dni" id="edit_dni" >
                    </div>                    
                    <div class="form-group">
                        <label for="edit_email">Email:</label>
                        <input type="email" class="form-control" name="email" id="edit_email" required>
                    </div>                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editarAdmin(id, nombre, apellido, dni, email) {
    // Rellenar el formulario con los datos
    document.getElementById('edit_id_persona').value = id;
    document.getElementById('edit_nombre').value = nombre;
    document.getElementById('edit_apellido').value = apellido;
    document.getElementById('edit_dni').value = dni;
    document.getElementById('edit_email').value = email;
    $('#editModal').modal('show');
}
document.getElementById('editForm').addEventListener('submit', function(e) {
    return true;
});
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('contrasena');
    const toggleEyeBtn = document.getElementById('toggle-eye');

    // Check if elements exist
    if (passwordInput && toggleEyeBtn) {
        toggleEyeBtn.addEventListener('click', function() {
            // Toggle password visibility
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                // Replace eye icon with eye-slash
                this.innerHTML = '<i class="fas fa-eye-slash p-1"></i>';
            } else {
                passwordInput.type = 'password';
                // Replace eye-slash with eye
                this.innerHTML = '<i class="fas fa-eye p-1"></i>';
            }
        });
    }

    // Modal close buttons
    const modalCloseButtons = document.querySelectorAll('.modal .close, .modal [data-dismiss="modal"]');
    modalCloseButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                // Using jQuery to hide the modal
                $(modal).modal('hide');
            }
        });
    });
});
</script>

<script src="../../js/alertas.js"></script>
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>
<?php require 'footer.php'; ?>