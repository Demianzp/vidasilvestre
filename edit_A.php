<!-- <!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Registro de Notas del Centro Escolar Profesor Lennin" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoI6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head> -->
<?php require 'navbar.php'; ?>
<body>
    <div class="container mt-3">
        <div class="row d-flex justify-content-center">
            <div class="col-auto">
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white">Editar</h5>
                    <div class="card-body bg-light">
                        <form method="post" class="form" action="edit_A2.php">
                        <?php
                              include ('conn/conexion.php');
                                $sql = "SELECT * FROM asignar WHERE id_asignar =".$_GET['id'];
                                    $resultado = $conexion->query($sql);
                                  $row = $resultado->fetch_assoc();
                                    ?>
                                <input type="hidden" class="form-control" name="Id" value="<?php echo $row['id_asignar']?>">
                           
                           <!-- -----------------Antes ESTABA ASí------------------------ -->
                           <!-- <div class="form-group">
                            <label for="profesor">Profesor:</label>
                            <select name="profesor" class="form-control" >
                            <?php 
                            // include('conn/conexion.php');
                            // $sql = $conexion->query("SELECT * FROM persona WHERE id_rol = 2 AND estado = 'Activo' AND id_persona=".$row['id_persona']);
                            // while ($resultado3=$sql -> fetch_assoc()){
                            // echo "<option value='".$resultado3["id_persona"]."'>".$resultado3["nombre"]." ".$resultado3["apellido"]."</option>";
                            // }                        
                            ?>
                                </select>
                            </div> -->
                            <!-- --------------------------------------------------------- -->
                            <!-- ---------------El get trae el id del profesor q quiere asignar la materia------------------ -->
                            <div class="form-group">                                
                                <?php 
                                    include('conn/conexion.php');
                                    $sql = $conexion->query("SELECT * FROM persona WHERE id_rol = 2 AND estado = 'Activo' AND id_persona=".$row['id_persona']);
                                    $resultado3=$sql -> fetch_assoc();                                    
                                ?>
                                <!-- -----------------------------     -->
                                <label for="profesor">Profesor:</label>
                                <input name="profesor" value="<?php echo $resultado3["nombre"] . " " . $resultado3["apellido"];?>" class="form-control" readonly onmousedown="return false">                                                      
                            </div>
                             <!-- --------------------------------- -->
                            <div class="form-group">
                                <label for="materia">Materia:</label>
                                <select name="materia" class="form-control" required>
                                <?php
                                    include ('conn/conexion.php');
                                    $sql = $conexion->query("SELECT * FROM materia WHERE id_materia=".$row['id_materia']);
                                    while ($resultado1=$sql -> fetch_assoc()){
                                    echo "<option selected value='".$resultado1["id_materia"]."'>".$resultado1["Nombre"]."</option>";    
                                    }     
                                    $sql2 = "SELECT * FROM materia";
                                        $resultado2 = $conexion->query($sql2);
                                        while ($Fila = $resultado2->fetch_array()) {
                                        echo "<option value='".$Fila['id_materia']."'>".$Fila['Nombre']."</option>";
                                    };
                                ?>
                                </select>
                            </div>                            
                                <!-- --------------------------------- -->
                          <div class="form-group">
                                <input type="hidden" class="form-control" name="Estado" value="Activo" disabled>                              
                            </div>
                            <!-------------------------------------------------------------->                            
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <a  class="btn btn-warning" href="lista_A.php">Volver</a>
                            </div>                        
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require 'footer.php'; ?>  
</body>



