<?php
require 'conn/connection.php'; // Asegúrate de que el archivo de conexión esté en la ubicación correcta
session_start();
if($_POST){
    $messages = [
        "1" => "Credenciales incorrectas",
        "2" => "No ha iniciado sesión",
        "3" => "No tienes permisos"
    ];
    // Verificar si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener los datos del formulario
        $email = $_POST['email'];
        $contrasena = $_POST['contrasena'];
        // Validar que tanto el email como la contraseña se proporcionen
        if (!empty($email) && !empty($contrasena)) {
            // Consulta SQL para verificar las credenciales con marcadores de posición
            $sql = "SELECT * FROM persona WHERE email_correo = :email AND contraseña = :contrasena";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
            $stmt->execute();
            // Comprobar si se encontraron resultados
            if ($stmt->rowCount() > 0) {
                // Credenciales válidas, redirigir al usuario a la página de inicio
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
                // Establecer información del usuario en la sesión
                $_SESSION["id_rol"] = $usuario['id_rol']; // Almacena el ID de rol del usuario
                $_SESSION["nombre"] = $usuario['nombre']; // Almacena el nombre del usuario
                if ($usuario['id_rol'] == 1) {
                    // Configura un mensaje de "No tienes permisos" en la variable de sesión
                    $_SESSION['message'] = $messages[3];
                } else {
                    // Rol 2 o 3: Redirige a la página de inicio
                    header('Location: inicio.view.php');
                    exit;
                }
            } else {
                // Configura un mensaje de "Credenciales incorrectas" en la variable de sesión
                $_SESSION['message'] = $messages[1];
            }
        } else {
            // Configura un mensaje de "Credenciales incorrectas" en la variable de sesión si no se proporcionan credenciales
            $_SESSION['message'] = $messages[1];
        }
    }
    // Si el formulario no se ha enviado, redirigir al usuario al formulario de inicio de sesión
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang= "es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <meta name="description" content="Inicio de Sesión" />   
    <title>Instituto Superior Vida Silvestre</title>
    <link rel="shortcut icon" href="img/LOGO.png" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@700&family=Roboto&display=swap');
        body {
            background: linear-gradient(135deg, #98c343, #10801c);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="container d-flex justify-content-center">
    <div class="bg-white p-4 rounded-5 text-secondary shadow my-2" style="width: 25rem">
        <div class="d-flex justify-content-center">
            <img src="img/LOGO.png" alt="login-icon" style="height: 15rem" />
        </div>
        <div class="text-center fs-1 fw-bold">Bienvenid@</div>
        <form method="post" class="form" action="">
            <div class="input-group mt-4">
                <div class="input-group-text bg-info">
                    <img src="img/username-icon.svg" alt="username-icon" style="height: 1rem" />
                </div>
                <input class="form-control bg-light" type="text" placeholder="Email" name="email" autocomplete="off" required />
            </div>
            <div class="input-group mt-2">
                <div class="input-group-text bg-info">
                    <img src="img/padlock-svgrepo-com.svg" alt="password-icon" style="height: 1rem" />
                </div>
                <input class="form-control bg-light" type="password" placeholder="Contraseña" name="contrasena" id="password" autocomplete="off" required />
                <button type="button" class="btn btn-outline-primary" name="toggle-eye" id="toggle-eye" onclick="togglePasswordVisibility()">
                    <i class="fas fa-eye p-1"></i>
                </button>
            </div>
            <button type="submit" class="btn btn-primary text-white w-100 mt-4 fs-5 fw-semibold shadow-sm">Inicio</button>
            <?php
    if (isset($_SESSION['message'])) {
        echo '<div class="error text-danger border border-danger w-100 justify-content-center text-center d-inline-block mt-2 rounded-3 p-1"  id="myAlert" style="background-color: #f5c2c7">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
    }
    ?>
        </form>
    </div>
</body>
<script src="js/contraseña.js"></script>
</html>
