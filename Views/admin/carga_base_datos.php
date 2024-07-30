<?php
require '../../conn/connection.php';
// ---------------------------------------------
$conexion = mysqli_connect("localhost", "root", "", "vidasilvestre");
// ---------------------------------------------
$sql_examen = "SELECT * FROM examen ";
$resul_exa = $conexion->query($sql_examen);
$examen = $resul_exa->fetch_assoc();
$select_examen = $examen['id_examen_tipo'];
// ---------------------------------------------
$sql_persona = "SELECT * FROM persona ";
$resul_persona = $conexion->query($sql_persona);
$persona = $resul_persona->fetch_assoc();
$select_persona = $persona['id_persona'];
// ---------------------------------------------

$sql_ciclo = "SELECT * FROM ciclo_lectivo ";
$resul_ciclo = $conexion->query($sql_ciclo);
$ciclo = $resul_ciclo->fetch_assoc();
$select_ciclo = $ciclo['id_ciclo'];
// ---------------------------------------------
$sql_materia = "SELECT * FROM materia ";
$resul_materia = $conexion->query($sql_materia);
$materia = $resul_materia->fetch_assoc();
$select_materia = $materia['id_materia'];
// ---------------------------------------------
if($examen['id_examen_tipo']===null){   
$sql = "INSERT INTO examen (id_examen_tipo,nombre_examen)
VALUES
(1,'nota1'),
(2,'nota2'),
(3,'nota3'),
(4,'nota4'),
(5,'calificacion regular'),
(6,'calificacion 1º examen final'),
(7,'calificacion 2º examen final'),
(8,'calificacion final'),
(9,'1º per. ev. dic.'),
(10,'2º per. ev. dic.'),
(11,'1º per. ev. feb.'),
(12,'1º per. ev. feb.'),
(13,'calificacion definitiva')";
$stmt = mysqli_query($conexion,$sql);
}
// ----------------------------------------------
if($persona['id_persona']===null){  
$sql = "INSERT INTO persona (nombre, apellido, email_correo, contraseña, id_rol, estado) 
        VALUES ('maxi', 'olmos', 'm@gmail.com', '123', 3,'Activo')";
$stmt = mysqli_query($conexion,$sql);
// -----------------------------------------------
$sql2 = "INSERT INTO persona (nombre, apellido, fecha_nacimiento, DNI, celular, email_correo, direccion, fecha_ingreso, pais, ciudad, contraseña, id_rol, genero, legajo, titulo, estado) 
VALUES ('Juan', 'Perez', '2014-06-20', 44231783, '26', 'adminjuan@gmail.com', '9 de julio y san juan', '2024-06-12', 'Argentina', 'Angaco', '123456', 1, 'Masculino', 2332423, 'Preceptor', 'Activo')";
$stmt2 = mysqli_query($conexion,$sql2);
// ------------------------------------------
$sql3 = "INSERT INTO persona (nombre, apellido, fecha_nacimiento, DNI, celular, email_correo, direccion, fecha_ingreso, pais, ciudad, contraseña, id_rol, genero,legajo , titulo, estado) 
VALUES ('Demi', 'Perez', '2014-06-20', 44231783, '26', 'dem23@gmail.com', '9 de julio y san juan', '2024-06-12', 'Argentina', 'Angaco', '123456', 2, 'Masculino', 2332423, 'Preceptor', 'Activo')";
$stmt3 = mysqli_query($conexion,$sql3);
}
// ----------------------------------------------
if($ciclo['id_ciclo']===null){  
$sql = "INSERT INTO ciclo_lectivo ( nombre_ciclo, fecha_inicio, fecha_fin, Estado, created_at, updated_at, ciclo_actual) 
VALUES ('2024', '2024-06-19', '2024-06-26', 'Activo', '2024-06-08 10:24:14', '2024-06-10 14:31:14', 1);";
$stmt = mysqli_query($conexion,$sql);   
}
// ----------------------------------------------
if($materia['id_materia']===null){  
$sql = "INSERT INTO materia (Nombre, descripcion, horas, num_resolucion, plan_estudio, año_cursado, id_tipo, estado) 
VALUES ('lengua', 'd2', '2', '3', '1', '1', 2, 'Activo');";
$stmt = mysqli_query($conexion,$sql);   
}    


header("Location: ../");




?>