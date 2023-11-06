<?php
session_start(); // Asegúrate de incluir esto al principio del archivo.....

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); // Borra el mensaje después de mostrarlo
} else {
    $message = ""; // Inicializa la variable de mensaje si no hay un mensaje en la sesión
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enlace a Bootstrap CSS -->
    <meta name="description" content="Formulario de Inscripcion" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Formulario de Inscripción de Profesor</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto&display=swap');
    </style>
</head>

<body>
    <?php require 'navbar.php'; ?>
    <!-- "content" es diferente que "container" -->
    <div class="container mt-3">
        <div class="card rounded-2 border-0">
            <h5 class="card-header bg-dark text-white">Formulario de Inscripción de Profesor</h5>
            <div class="card-body bg-light">
            <?php
                if (!empty($message)) {
                    echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
                }
                ?>
                <form id="formulario" method="post" action="profesor2.php">
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
                                <input type="text" class="form-control" name="dni" id="dniOK" placeholder="Ingrese DNI" autocomplete="off" required>
                                <span id="dniOK"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="col">
                                <div class="form-group">
                                    <label for="celular">Celular:</label>
                                    <input type="tel" class="form-control" name="celular" placeholder="Ingrese Teléfono" id="celular" autocomplete="off" required>
                                    <span id="celularOK"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- --------------------------------- -->
                    <div class="row">
                        <!-- --------------------------------- -->
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
                        <div class="col">
                            <div class="form-group">
                                <label for="rol">Rol:</label>
                                <select name="id_rol" id="rol" class="form-control" required>
                                    <option value="" disabled selected>Seleccione el usuario</option>
                                    <option value="1">Alumno</option>
                                    <option value="2">Profesor</option>
                                    <option value="3">Administrador</option>
                                    <!-- Agrega otras opciones de roles aquí -->
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
                                <input class="form-control bg-light" type="password" placeholder="Contraseña" name="contrasena" id="password" autocomplete="off" required />
                                <button type="button" class="btn btn-outline-primary" name="toggle-eye" id="toggle-eye" onclick="togglePasswordVisibility()">
                                    <i class="fas fa-eye p-1"></i>
                                </button>
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
    <?php require 'footer.php'; ?>
</body>
<script src="js/contraseña.js"></script>
<script src="js/validacion.js"></script>
<script src="js/validacion2.js"></script>

</html>
