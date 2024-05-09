<?php
include '../../conn/connection.php';
// Verifica si se envió una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensaje = "";
    $error = "";
    // Recolecta datos del formulario
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $dni = $_POST["dni"];
    $celular = $_POST["celular"];
    $email = $_POST["email"];
    $direccion = $_POST["direccion"];
    $ciudad = $_POST["ciudad"];
    $genero = $_POST["genero"];
    $pais = "Argentina";
    $fecha_nacimiento = $_POST["fecha_nacimiento"];
    $fecha_ingreso = $_POST["fecha_ingreso"];
    $contrasena = $_POST["contrasena"];
    $estado = "Activo"; // Valor predeterminado para estado
    $id_rol = "1"; //Valor  predeterminado para alumno es 1.
    try {
        // Verificar si el correo electrónico ya existe
        $sql_check_email = "SELECT COUNT(*) FROM persona WHERE email_correo = :email"; // Falta la comilla
        $stmt_check_email = $db->prepare($sql_check_email);
        $stmt_check_email->bindParam(':email', $email);
        $stmt_check_email->execute();
        $count = $stmt_check_email->fetchColumn(); // Obtiene el número de registros
        if ($count > 0) {
            // El correo ya está registrado, genera un mensaje de error
            $error = "El correo electrónico ya está registrado. Por favor, use uno diferente.";
        } else {
            // Inserta datos en la base de datos
            $sql = "INSERT INTO persona (nombre, apellido, fecha_nacimiento, DNI, celular, email_correo, direccion, fecha_ingreso, pais, ciudad, contraseña, id_rol, genero, estado) 
                        VALUES (:nombre, :apellido, :fecha_nacimiento, :dni, :celular, :email, :direccion, :fecha_ingreso, :pais, :ciudad, :contrasena, :id_rol, :genero, :estado)";

            $stmt = $db->prepare($sql);
            // Vincula los parámetros para la inserción
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
            $stmt->bindParam(':dni', $dni);
            $stmt->bindParam(':celular', $celular);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':direccion', $direccion);
            $stmt->bindParam(':fecha_ingreso', $fecha_ingreso);
            $stmt->bindParam(':pais', $pais);
            $stmt->bindParam(':ciudad', $ciudad);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':id_rol', $id_rol);
            $stmt->bindParam(':genero', $genero);
            $stmt->bindParam(':estado', $estado);

            // Ejecuta la inserción y maneja errores
            if ($stmt->execute()) {
                $mensaje = "Persona ingresada con éxito.";
            } else {
                $error = "Error al ingresar Persona.";
            }
        }
    } catch (PDOException $e) {
        $error = "Error en la base de datos: " . $e->getMessage();
    }

    // Redirige con el mensaje y el error codificados
    header("Location: alumno_index.php?mensaje=" . urlencode($mensaje) . "&error=" . urlencode($error));
    exit();
}
?>
<!-- ----------------------------------- -->
<?php require 'navbar.php'; ?>
    <!-- "content" es diferente que "container" -->
    <div class="container mt-3">
        <div class="card rounded-2 border-0">
            <h5 class="card-header bg-dark text-white">Formulario de Inscripción de Alumno</h5>
            <div class="card-body bg-light">
            <?php
                if (!empty($message)) {
                    echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
                }
                ?>
                <form id="formulario" action="" method="post" enctype="multipart/form-data">
                    <!-- --------------------------------- -->
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" autocomplete="off" placeholder="Ingrese Nombre(s)" required>
                            </div>
                        </div>
                    <!-- --------------------------------- -->
                        <div class="col">
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" class="form-control" name="apellido" autocomplete="off" placeholder="Ingrese Apellido(s)" required>
                            </div>
                        </div>
                    </div>
                    <!-- --------------------------------- -->
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" name="dni" id="dni" placeholder="Ingrese DNI" autocomplete="off" required>
                                <span id="dniOK"></span>
                            </div>
                        </div>
                        <div class="col">                            
                            <div class="form-group">
                                <label for="celular">Celular:</label>
                                <input type="tel" class="form-control" name="celular" placeholder="Ingrese Teléfono" id="celular" autocomplete="off" required>
                                <span id="celularOK"></span>
                            </div>
                            
                        </div>
                    </div>
                    <!-- --------------------------------- -->
                    <div class="row">                        
                        <div class="col">
                            <div class="form-group">
                                <label for="ciudad">Ciudad:</label>
                                <select name="ciudad" id="ciudad" class="form-control" autocomplete="off" required>
                                    <option value="" disabled selected>Seleccione un departamento de San Juan</option>
                                    <option value="Albardón">Albardón</option>
                                    <option value="Angaco">Angaco</option>
                                    <option value="Calingasta">Calingasta</option>
                                    <option value="Caucete">Caucete</option>
                                    <option value="Chimbas">Chimbas</option>
                                    <option value="Capital">Capital</option>
                                    <option value="Iglesia">Iglesia</option>
                                    <option value="Jáchal">Jáchal</option>
                                    <option value="9 de Julio">9 de Julio</option>
                                    <option value="Pocito">Pocito</option>
                                    <option value="Rawson">Rawson</option>
                                    <option value="Rivadavia">Rivadavia</option>
                                    <option value="San Martín">San Martín</option>
                                    <option value="Santa Lucía">Santa Lucía</option>
                                    <option value="Sarmiento">Sarmiento</option>
                                    <option value="Ullum">Ullum</option>
                                    <option value="Valle Fértil">Valle Fértil</option>
                                    <option value="Zonda">Zonda</option>
                                    <option value="25 de Mayo">25 de Mayo</option>
                                    <!-- Agrega otros departamentos de San Juan aquí -->
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" name="direccion" placeholder="Ingrese Direccion" autocomplete="off" required>
                            </div>
                        </div>
                    </div>
                    <!-- --------------------------------- -->
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="genero">Género:</label>
                                <select name="genero" autocomplete="off" class="form-control" required>
                                    <option value="" disabled selected>Seleccione su Género</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Femenino">Femenino</option>
                                    <option value="Otros">Otros</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                                <input type="date" class="form-control" name="fecha_ingreso" required>
                            </div>
                        </div>
                    </div>
                    <!-- --------------------------------- -->
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input id="email" class="form-control" name="email" placeholder="Ingrese Email" autocomplete="off" required>
                                <span id="emailOK"></span>
                            </div>
                        </div>                        
                        <div class="col">
                            <div class="form-group">
                                <label for="contraseña">Contraseña:</label>
                                <div class="input-group">
                                    <input class="form-control bg-light d-inline-block" type="password" placeholder="Contraseña" name="contrasena" id="password" autocomplete="off" required />
                                    <button type="button" class="btn btn-outline-primary" name="toggle-eye" id="toggle-eye" onclick="togglePasswordVisibility()">
                                        <i class="fas fa-eye p-1"></i>
                                    </button>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <!-- --------------------------------- -->
                    <!-- Agregamos un botón para guardar con un evento JavaScript -->
                    <button type="button" class="btn btn-primary float-right" id="guardarBtn" onclick="validarFormulario()">Guardar</button>
                    <!-- Agregamos un div para mostrar un mensaje de confirmación -->
                    <div id="confirmacion" style="display: none;">
                        <p>¿Seguro desea guardar los datos?</p>
                        <button type="button" class="btn btn-success" id="confirmarBtn">Sí</button>
                        <button type="button" class="btn btn-danger" id="cancelarBtn">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
<script src="../../js/contraseña.js"></script>
<script src="../../js/validacion.js"></script>
<script src="../../js/validacion2.js"></script>

<?php require 'footer.php'; ?>