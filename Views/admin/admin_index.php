<?php
require '../../conn/connection.php';
//-------------BORRADO------------------ 
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $db->prepare("UPDATE persona SET estado = 'Inactivo' WHERE id_persona = :id");
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();
    $mensaje = "Registro Administrador Eliminado";
    header("Location:admin_index.php?mensaje=" . $mensaje);
}
//<!-- ------------------------------------------ -->
//<!-- ------------------------------------------ -->
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recolecta datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $dni  = $_POST["dni"];
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];
    $genero = $_POST["genero"];
    $celular = $_POST["celular"];
    $direccion = $_POST["direccion"];
    $ciudad = $_POST["ciudad"];
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $estado = "Activo"; // Valor predeterminado para estado
    $id_rol = "3"; // Valor predeterminado para administrador
    $pais = "Argentina"; // Valor predeterminado
    $error = "";

    try {
        // Verificar si el correo electrónico ya existe
        $sql_check_email = "SELECT COUNT(*) FROM persona WHERE email_correo = :email";
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
            // Inserta datos en la base de datos
            $sql = "INSERT INTO persona 
                    (nombre, apellido,DNI ,email_correo, contraseña, id_rol, estado, fecha_ingreso, genero, pais, celular, direccion, ciudad, fecha_nacimiento) 
                    VALUES 
                    (:nombre, :apellido, :dni ,:email, :contrasena, :id_rol, :estado, NOW(), :genero, :pais, :celular, :direccion, :ciudad, :fecha_nacimiento)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':id_rol', $id_rol);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':genero', $genero);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':celular', $celular);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);

            if ($stmt->execute()) {
                header("Location: admin_index.php?mensaje=" . urlencode("Administrador ingresado con éxito."));
                exit();
            } else {
                $error = "Error al ingresar Administrador.";
            }
        }
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
        $redirect_url = "admin_index.php?error=" . urlencode($error)
            . "&nombre=" . urlencode($nombre)
            . "&apellido=" . urlencode($apellido)
            . "&email=" . urlencode($email);
        header("Location: " . $redirect_url);
        exit();
    }
}
?>

<!-- ------------------------------ -->
<?php require 'navbar.php'; ?>
<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <!-- -------------------- -->
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
                                        <th>Acciones</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                        try {
                                            $db = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
                                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <a href="javascript:eliminar4(<?php echo $persona['id_persona']; ?>)" class="btn btn-danger btn-sm" type="button" title="Borrar">
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
                            <?php
                            /*Recupera el mensaje de error y los datos del formulario desde la URL
                            $error = isset($_GET["error"]) ? $_GET["error"] : "";
                            $nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : "";
                            $apellido = isset($_GET["apellido"]) ? $_GET["apellido"] : "";
                            $email = isset($_GET["email"]) ? $_GET["email"] : "";
                            $genero = "";*/
                            ?>
                            <form id="formulario" action="" method="post">
                                <!-- Primera parte -->
                                <div id="parte1">
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" placeholder="Ingrese Nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="apellido">Apellido:</label>
                                        <input type="text" class="form-control" name="apellido" value="<?php echo htmlspecialchars($apellido); ?>" placeholder="Ingrese Apellido" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="dni">DNI:</label>
                                        <input type="text" class="form-control" name="dni" id="dni" placeholder="Ingrese su DNI" required>
                                        <span id="dniOK"></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                        <input type="date" class="form-control" name="fecha_nacimiento" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" autocomplete="off" placeholder="Ingrese su email" required>
                                        <span id="emailOK"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="passwordd">Contraseña:</label>
                                    <div class="input-group">
                                        <input class="form-control bg-light" type="password" placeholder="Contraseña" name="passwordd" id="passwordd" autocomplete="off" required />
                                        <button type="button" class="btn btn-outline-primary" name="toggle-eye" id="toggle-eye" onclick="togglePasswordVisibility()">
                                            <i class="fas fa-eye p-1"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary" id="btnContinuar" onclick="mostrarSegundaParte()">Siguiente</button>



                                <!-- Segunda parte -->
                                <div id="parte2" style="display:none;">
                                    <div class="form-group">
                                        <label for="genero">Género:</label>
                                        <select name="genero" class="form-control" required>
                                            <option value="" disabled selected>Seleccione su Género</option>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Otros">Otros</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="celular">Celular:</label>
                                        <input type="tel" class="form-control" name="celular" id="celular" autocomplete="off" placeholder="Ingrese Telefono" required>
                                        <span id="celularOK"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="ciudad">Ciudad:</label>
                                        <select name="ciudad" id="ciudad" class="form-control" autocomplete="off" required>
                                            <option value="" disabled <?php echo ($ciudad == "") ? "selected" : ""; ?>>Seleccione un departamento de San Juan</option>
                                            <option value="Albardón" <?php echo ($ciudad == "Albardon") ? "selected" : ""; ?>>Albardón</option>
                                            <option value="Angaco" <?php echo ($ciudad == "Angaco") ? "selected" : ""; ?>>Angaco</option>
                                            <option value="Calingasta" <?php echo ($ciudad == "Calingasta") ? "selected" : ""; ?>>Calingasta</option>
                                            <option value="Caucete" <?php echo ($ciudad == "Caucete") ? "selected" : ""; ?>>Caucete</option>
                                            <option value="Chimbas" <?php echo ($ciudad == "Chimbas") ? "selected" : ""; ?>>Chimbas</option>
                                            <option value="Capital" <?php echo ($ciudad == "Capital") ? "selected" : ""; ?>>Capital</option>
                                            <option value="Iglesia" <?php echo ($ciudad == "Iglesia") ? "selected" : ""; ?>>Iglesia</option>
                                            <option value="Jáchal" <?php echo ($ciudad == "Jáchal") ? "selected" : ""; ?>>Jáchal</option>
                                            <option value="9 de Julio" <?php echo ($ciudad == "9 de Julio") ? "selected" : ""; ?>>9 de Julio</option>
                                            <option value="Pocito" <?php echo ($ciudad == "Pocito") ? "selected" : ""; ?>>Pocito</option>
                                            <option value="Rawson" <?php echo ($ciudad == "Rawson") ? "selected" : ""; ?>>Rawson</option>
                                            <option value="Rivadavia" <?php echo ($ciudad == "Rivadavia") ? "selected" : ""; ?>>Rivadavia</option>
                                            <option value="San Martín" <?php echo ($ciudad == "San Martín") ? "selected" : ""; ?>>San Martín</option>
                                            <option value="Santa Lucía" <?php echo ($ciudad == "Santa Lucía") ? "selected" : ""; ?>>Santa Lucía</option>
                                            <option value="Sarmiento" <?php echo ($ciudad == "Sarmiento") ? "selected" : ""; ?>>Sarmiento</option>
                                            <option value="Ullum" <?php echo ($ciudad == "Ullum") ? "selected" : ""; ?>>Ullum</option>
                                            <option value="Valle Fértil" <?php echo ($ciudad == "Valle Fértil") ? "selected" : ""; ?>>Valle Fértil</option>
                                            <option value="Zonda" <?php echo ($ciudad == "Zonda") ? "selected" : ""; ?>>Zonda</option>
                                            <option value="25 de Mayo" <?php echo ($ciudad == "25 de Mayo") ? "selected" : ""; ?>>25 de Mayo</option>
                                            <!-- Agrega otros departamentos de San Juan aquí -->
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="direccion">Dirección:</label>
                                        <input type="text" class="form-control" name="direccion" placeholder="Ingrese su dirección" required>
                                    </div>

                                   
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<script>
   function mostrarSegundaParte() {
    var parte1 = document.getElementById('parte1');
    var parte2 = document.getElementById('parte2');
    var inputsParte1 = parte1.querySelectorAll('input');
    var valid = true;

    inputsParte1.forEach(function(input) {
        if (!input.checkValidity()) {
            valid = false;
        }
    });

    if (valid) {
        parte1.style.display = 'none';
        parte2.style.display = 'block';
        document.getElementById('btnContinuar').style.display = 'none';
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Campos incompletos',
            text: 'Por favor, completa todos los campos antes de continuar.'
        });
    }
}
</script>
<script src="../../js/alertas.js"></script>
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>
<?php require 'footer.php'; ?>