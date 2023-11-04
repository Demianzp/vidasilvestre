<?php
$conexion= mysqli_connect("localhost", "root", "", "vidasilvestre");

if(isset($_POST['registrar'])){

    if(strlen($_POST['nombre']) >=1 && strlen($_POST['apellido'])  >=1 && strlen($_POST['fechaN'])  >=1 
    && strlen($_POST['dni'])  >=1 && strlen($_POST['telefono']) >= 1 && strlen($_POST['correo']) >= 1 && strlen($_POST['direccion']) >= 1 && strlen($_POST['ciudad']) >= 1 && strlen($_POST['pais']) >= 1 
    && strlen($_POST['genero']) >= 1 
    && strlen($_POST['fechaI']) >= 1 && strlen($_POST['rol']) >= 1  ){

    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $fechaN = trim($_POST['fechaN']);
    $dni = trim($_POST['dni']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $direccion = trim($_POST['direccion']);
    $ciudad = trim($_POST['ciudad']);
    $pais = trim($_POST['pais']);
    $genero = trim($_POST['genero']);
    $fechaI = trim($_POST['fechaI']);
    $rol = trim($_POST['rol']);

    $consulta= "INSERT INTO persona (nombre, apellido, facha_nacimiento, DNI, Telefono, email_correo, direccion, ciudad, pais, genero, fecha_ingreso, id_rol )
  VALUES ('$nombre', ' $apellido', '$fechaN', ' $dni', '$telefono','$correo','$direccion', ' $ciudad', ' $pais', ' $genero', '$fechaI', '$rol' )";

    mysqli_query($conexion, $consulta);
    mysqli_close($conexion);

    header('Location: ../views/user.php');
  }
}









?>