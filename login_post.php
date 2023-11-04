<?php
require 'conn/connection.php'; // Asegúrate de que el archivo de conexión esté en la ubicación correcta
session_start();

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
?>
