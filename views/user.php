
<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <title>Usuarios</title>
</head>
<br>
<div class="container is-fluid">




<div class="col-xs-12">
		<h1>Lista de usuarios</h1>
    <br>
		<div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create">
				<span class="glyphicon glyphicon-plus"></span> Nuevo Profesor </a></button>
		<br>



   
           <br>


			</form>
      <div class="container-fluid">
  <form class="d-flex">
      <input class="form-control me-2 light-table-filter" data-table="table_id" type="text" 
      placeholder="Buscar ">
      <hr>
      </form>
  </div>

  <br>

 
      <table class="table table-bordered table-striped table_id ">

                   
                         <thead>    
                         <tr>
                         <th >#</th>
                                <th >Nombres</th>
                                <th >Apellidos</th>
                                <th>Fecha de nacimiento</th>
                                <th >DNI </th>
                                <th >Teléfono</th>
                                <th >Email</th>
                                <th >Dirección</th>
                                <th >Ciudad</th>
                                <th >Nacionalidad</th>
                                <th >Genero</th>
                                <th >Fecha de ingreso</th>
                                <th >Rol</th>
                                <th >Acción</th>
         
                        </tr>
                        </thead>
                        <tbody>

				<?php

$conexion=mysqli_connect("localhost","root","","vidasilvestre");               
$SQL="SELECT id_persona, nombre, apellido, facha_nacimiento, DNI, Telefono, email_correo, direccion, fecha_ingreso, pais, ciudad, contraseña, id_rol, genero, estado FROM persona where id_rol =2";
$dato = mysqli_query($conexion, $SQL);

if($dato -> num_rows >0){
    while($fila=mysqli_fetch_array($dato)){
    
?>
<tr>
                    <td><?php echo $fila['id_persona']; ?></td>
                    <td><?php echo $fila["nombre"]; ?></td>
                    <td><?php echo $fila["apellido"];?></td>
                    <td><?php echo $fila["facha_nacimiento"];?></td>
                    <td><?php echo $fila["DNI"] ;?></td>
                    <td><?php echo $fila["Telefono"];?></td>
                    <td><?php echo $fila["email_correo"];?></td>
                    <td style='width:20%;'><?php echo substr(utf8_encode(" ".$fila["direccion"]),1);?>
                    </td>
                    <td><?php echo $fila["ciudad"];?></td>
                    <td><?php echo $fila["pais"];?></td>
                    <td><?php if($fila["genero"]==1){echo 'Masculino';}else{echo '
                    Femenino';};?></td>
                    <td><?php echo date('d-m-Y',strtotime($fila["fecha_ingreso"]));
                    ?></td>
                    <td><?php echo $fila["id_rol"];?></td>



<td>


<a class="btn btn-warning" href="editar_user.php ">
<i class="fa fa-edit"></i> </a>

  <a class="btn btn-danger"  href="eliminar_user.php">
<i class="fa fa-trash"></i></a>

</td>
</tr>


<?php
}
}else{

    ?>
    <tr class="text-center">
    <td colspan="16">No existen registros</td>
    </tr>

    
    <?php
    
}

?>


	</body>
  </table>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script src="../js/user.js"></script>
<script src="../js/acciones.js"></script>
<script src="../js/buscador.js"></script>




		<?php include('../profe.php'); ?>
</html>