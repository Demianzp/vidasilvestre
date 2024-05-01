<?php
require 'conn/connection.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$mensaje = "";
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
    $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : '';
    $dni = isset($_POST["dni"]) ? $_POST["dni"] : '';
    $celular = isset($_POST["celular"]) ? $_POST["celular"] : '';
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $direccion = isset($_POST["direccion"]) ? $_POST["direccion"] : '';
    $ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : '';
    $genero = isset($_POST["genero"]) ? $_POST["genero"] : '';
    $id_rol = isset($_POST["id_rol"]) ? $_POST["id_rol"] : '';
    $pais = isset($_POST["pais"]) ? $_POST["pais"] : '';
    $fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? $_POST["fecha_nacimiento"] : '';
    $fecha_ingreso = isset($_POST["fecha_ingreso"]) ? $_POST["fecha_ingreso"] : '';
    $contrasena = isset($_POST["contrasena"]) ? $_POST["contrasena"] : '';

    // Definir el valor predeterminado para el campo "estado" (asumiendo que se llama "estado")
    $estado = "Activo";
    $pais = "Argentina";

    try {
        $sql = "INSERT INTO persona (nombre, apellido, fecha_nacimiento, DNI, celular, email_correo, direccion, fecha_ingreso, pais, ciudad, contraseña, id_rol, genero, estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);

        if ($stmt) {
            $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
            $stmt->bindParam(2, $apellido, PDO::PARAM_STR);
            $stmt->bindParam(3, $fecha_nacimiento, PDO::PARAM_STR);
            $stmt->bindParam(4, $dni, PDO::PARAM_STR);
            $stmt->bindParam(5, $celular, PDO::PARAM_STR);
            $stmt->bindParam(6, $email, PDO::PARAM_STR);
            $stmt->bindParam(7, $direccion, PDO::PARAM_STR);
            $stmt->bindParam(8, $fecha_ingreso, PDO::PARAM_STR);
            $stmt->bindParam(9, $pais, PDO::PARAM_STR);
            $stmt->bindParam(10, $ciudad, PDO::PARAM_STR);
            $stmt->bindParam(11, $contrasena, PDO::PARAM_STR);
            $stmt->bindParam(12, $id_rol, PDO::PARAM_STR);
            $stmt->bindParam(13, $genero, PDO::PARAM_STR);
            $stmt->bindParam(14, $estado, PDO::PARAM_STR);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $mensaje = "Persona ingresada con éxito.";
            } else {
                $error = "Error al ingresar Persona: " . $stmt->errorInfo()[2];
            }
        }
    } catch (PDOException $e) {
        $error = "Error en la consulta: " . $e->getMessage();
    }
}
// Redirigir a la página "listadoalumnos.view.php" con los mensajes en la URL
header("Location: listadoprofe.php?mensaje=" . urlencode($mensaje) . "&error=" . urlencode($error));
exit();
}
?>
<!-- ------------------------------------------------------------------- -->
<?php
session_start(); // Asegúrate de incluir esto al principio del archivo.....
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Borra el mensaje después de mostrarlo
} else {
    $message = "";
}
?>
<!-- ---------------------------------------------------- -->
<?php require 'navbar.php'; ?>
    <div class="container mt-3">
        <div class="card rounded-2 border-0">
            <h5 class="card-header bg-dark text-white">Formulario de Inscripción de Profesor</h5>
            <div class="card-body bg-light">
                <?php
                if (!empty($message)) {
                    echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
                }
                ?>
                <form id="formulario" method="post" action="">
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
                                <input  type="hidden" class="form-control" name="id_rol" value="2">
                    <!-- --------------------------------- -->
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" name="fecha_nacimiento" required>
                            </div>
                        </div>
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
                    <!-- --------------------------------- -->
                      <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="titulo">Titulo:</label>
                                <input type="text" class="form-control" name="titulo"  placeholder="Ingrese Titulo" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                            <label for="legajo">Legajo:</label>
                                <input type="text" class="form-control" name="legajo" placeholder="Ingrese el n° de legajo" required>
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
                                    <input class="form-control bg-light" type="password" placeholder="Contraseña" name="contrasena" id="password" autocomplete="off" required />
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
                        <p>¿Estás seguro de que deseas guardar los datos?</p>
                        <button type="button" class="btn btn-success" id="confirmarBtn">Sí</button>
                        <button type="button" class="btn btn-danger" id="cancelarBtn">No</button>
                    </div>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
                        unset($_SESSION['message']); // Borra el mensaje después de mostrarlo
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
    

    <script src="js/contraseña.js"></script>
    <script src="js/validacion.js"></script>
    <script src="js/validacion2.js"></script>
<?php require 'footer.php'; ?>
