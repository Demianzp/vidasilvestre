<?php

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Registro de Notas del Centro Escolar" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Inicio | Registro de Notas</title>
</head>


<body>
    <?php require 'navbar.php'; ?>
    <div class="body">
        <div class="panel">
        <?php
        if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === true) {
            // Usuario autenticado, mostrar el contenido protegido
            echo "Bienvenido, usuario autenticado.<br>";
            // Puedes agregar más contenido aquí.
        } else {
            // Si el usuario no ha iniciado sesión, mostrar el formulario de inicio de sesión y mensajes de error si las credenciales son incorrectas
            if (isset($_GET['err']) && $_GET['err'] == 1) {
                echo " Credenciales incorrectas. Por favor, inténtalo de nuevo.<br>";
            }
        }
        ?>
            <h1 class="text-center">Centro Escolar Inicio</h1>
        </div>
    </div>

    <?php require 'footer.php'; ?>

</body>
</html>
