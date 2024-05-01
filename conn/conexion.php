<?php
// NO TRABAJAR CON ESTA CONECCION
$host = "localhost";
$user = "root";
$pass = "";
$db   = "vidasilvestre";
// Create connection
$conexion = new mysqli($host, $user, $pass, $db);
 
// Check connection
if (!$conexion) {
   echo 'Conexión fallida';
}
