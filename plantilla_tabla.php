<body>
<?php require 'navbar.php';?>
<!-- Main content -->
<section class="content mt-3" >
		<div class="row w-1 m-auto" >
			<div class="col-sm">
				<div class="card">
                	<div class="card-header ">
                        <div class="top">
                            <h3 class="card-title">Listado de Alumnos</h3>
                        </div>						
                        <a class="btn btn-primary mb-3 fw-semibold"style="float: right " href="alumnos.view.php">Agregar Alumno</a>
                	</div>
                    
                	<div class="card-body table-responsive">
                    	<!--MSK-00101-->
                		<table id="example1" class="table table-bordered table-striped">
                    		<thead>
                                <th >#</th>
                                <th >Apellidos</th>
                                <th >Nombres</th>
                                <th >Genero</th>
                                <th >Grado</th>
                                <th >Seccion</th>
                                <th >Editar</th>
                                <th >Eliminar</th>
                        	</thead>
                            <?php foreach ($alumnos as $alumno) :?>
                        	<tbody>
                                <tr>
                                <th scope="row"><?php echo $alumno['num_lista'] ?></th>
                                <td><?php echo $alumno['apellidos'] ?></td>
                                <td><?php echo $alumno['nombres'] ?></td>
                                <td><?php echo $alumno['genero'] ?></td>
                                <td><?php echo $alumno['grado'] ?></td>
                                <td><?php echo $alumno['seccion'] ?></td>
                                <td><a href="alumnoedit.view.php?id=<?php echo $alumno['id'] ?>"
                                        class="btn btn-warning" role="button"
                                        >Editar</a> </td>                            
                                <td><a href="alumnodelete.php?id=<?php echo $alumno['id'] ?>"
                                        class="btn btn-danger" role="button"                        
                                        >Eliminar</a> </td>
                                </tr>                            
							</tbody>
                            <?php endforeach;?>
						</table>	
                        <br>                    
                        <br><br>
                        <!--mostrando los mensajes que recibe a traves de los parametros en la url-->
                        <?php
                        if(isset($_GET['err']))
                            echo '<span class="error">Error al almacenar el registro</span>';
                        if(isset($_GET['info']))
                            echo '<span class="success">Registro almacenado correctamente!</span>';
                        ?>
					</div>
				</div>
			</div>
    	</div>
<?php require 'footer.php'; ?>
</body>
<!-- ----------------------------------------------- -->
<div class="container mt-3">
    <div class="card rounded-3">
        <h5 class="card-header">Formulario de Inscripción de Alumno</h5>
        <div class="card-body">
            <form action="">
            </form>
        </div>
    </div>
</div>
<!-- ----------------------------------------------- -->
<body>
<?php require 'navbar.php';?>
<!-- Main content -->
<section class="content mt-3" >
		<div class="row w-1 m-auto" >
			<div class="col-sm">
				<div class="card">
                	<div class="card-header ">
                        <div class="top">
                            <h3 class="card-title">Listado de Alumnos</h3>
                        </div>						
                        <a class="btn btn-primary mb-3 fw-semibold"style="float: right " href="alumnos.view.php">Agregar Alumno</a>
                	</div>
                    
                	<div class="card-body table-responsive">
                    	<!--MSK-00101-->
                		
                        
					</div>
				</div>
			</div>
    	</div>
<?php require 'footer.php'; ?>
</body>
<!-- ----------------------------------------------- -->



<div class="row justify-content-center align-items-center g-2">
    <div class="col">Column</div>
    <div class="col">Column</div>
    <div class="col">Column</div>
</div>

<!-- ----------------------- -->

<div class="row">
    <div class="col">
    </div>
</div>    













