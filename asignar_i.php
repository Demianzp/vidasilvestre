<?php
 include('conn/conexion.php');
$profesor = $_POST['profesor'];
$materia = $_POST['materia'];
$estado = 'Activo';

$sql = "INSERT INTO asignar (id_persona, id_materia, Estado) 
    VALUES ('$profesor', '$materia',' $estado')";


    $resultado= mysqli_query($conexion, $sql);
    if ($resultado === TRUE) {
       header("location: listadoprofe.php");
    } else {
        echo "Datos NO insertados";
    }



?>