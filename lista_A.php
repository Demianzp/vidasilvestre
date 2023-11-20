<!-- <!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asignación </title>
    <meta name="description" content="Registro de Notas del Centro Escolar">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head> -->
<?php require 'navbar.php'; ?>
<body>
    <section class="content mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <div class="card-header bg-dark text-white pb-0">
                        <h5 class="d-inline-block">Listado de Profesores</h5>
                        <a class="btn btn-primary float-right mb-2" href="listadoprofe.php">Volver</a>
                        <!-- <form class="form-group mx-sm-3 d-inline-block">
                            <input class="form-control  light-table-filter" data-table="table_id" type="text" placeholder="Buscar ">
                        </form> -->
                    </div>
                    <div class="card-body table-responsive">
                        <table id="example" class="table table-bordered table-striped table_id">
                            <thead class="thead-dark">
                                <th>#</th>
                                <th>Profesor</th>
                                <th>Materia</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </thead>
                            <tbody>
                                <?php
                                    require ("conn/conexion.php");
                                    $sql = $conexion -> query ("SELECT * FROM asignar
                                    INNER JOIN persona ON asignar.id_persona = persona.id_persona
                                    INNER JOIN materia ON asignar.id_materia = materia.id_materia");                                     
                                     while ($resultado = $sql -> fetch_assoc()) {
                                ?>
                                        <tr>
                                            <th scope="row"><?php echo $resultado['id_asignar'] ?></th>
                                            <td scope="row"><?php echo $resultado['nombre']?> <?php echo $resultado['apellido']?> </td>
                                            <td scope="row"><?php echo $resultado['Nombre'] ?></td> <!--Lo cambie en la BD materia-->
                                             <!--Lo cambie en la BD asignar----->
                                          <!--cambie los nombre en BD x q al tener el mismo nombre se mezclan las conexiones-->                                          
                                         <!-------BOTONES--->
                                            <td><a href="edit_A.php?id=<?php echo $resultado['id_asignar'] ?>" class="btn btn-warning" role="button">Editar</a></td>
                                            <td><a href="delet_A.php?id=<?php echo $resultado['id_asignar'] ?>" class="btn btn-danger" role="button">Eliminar</a></td>
                                        </tr>
                                <?php
                                 
                                 } 
                                
                                ?>
                            </tbody>
                        </table>
                        <br>
                        <br><br>
                        <!-- Mostrar mensajes que se reciben a través de los parámetros en la URL -->
                        <?php
                        if (isset($_GET['err'])) {
                            echo '<span class="error">Error al almacenar el registro</span>';
                        }
                        if (isset($_GET['info'])) {
                            echo '<span class="success">Registro almacenado correctamente!</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require 'footer.php'; ?>

</body>
<script src="js/buscador.js"></script>

</html>