<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        // El usuario eligió "Salir", puedes realizar la acción de cierre de sesión aquí
        session_start();
        session_destroy();
        header('Location: index.php'); // Redirige a la página de inicio (index.php) después de cerrar sesión
        exit;
    } elseif (isset($_POST['confirm']) && $_POST['confirm'] === 'no') {
        // El usuario eligió "No salir", redirige al usuario a la página de inicio (inicio.view.php)
        header('Location: inicio.view.php'); // Redirige a la página de inicio (inicio.view.php) si el usuario no desea salir
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cerrar Sesión | Sistema de Gestión Escolar</title>
    <meta name="description" content="Cerrar Sesión" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <?php require 'navbar.php'; ?>
    <h5>¿Estás seguro de que deseas salir del sistema?</h5>
    <form method="post">
        <button type="submit" name="confirm" value="yes" class="btn btn-danger">Si</button>
        <button type="submit" name="confirm" value="no" class="btn btn-success">No</button>
    </form>

    <?php require 'footer.php'; ?>
</body>
</html>