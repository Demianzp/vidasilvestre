<?php

$conexion=mysqli_connect("localhost","root","","vidasilvestre");               
$consulta="SELECT id_persona, nombre, apellido, facha_nacimiento, DNI, Telefono, email_correo, direccion, fecha_ingreso, pais, ciudad, contraseña, id_rol, genero, estado FROM persona ";
$resultado = mysqli_query($conexion, $consulta);
$usuario = mysqli_fetch_assoc($resultado);

?>


<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>


    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/es.css">
</head>

<body id="page-top">


<form  action="../includes/_functions.php" method="POST">
<div id="login" >
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                    
                            <br>
                            <br>
                            <h3 class="text-center">Editar usuario</h3>

                            <div class="form-group">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text"  id="nombre" name="nombre" class="form-control" value="<?php echo $usuario['nombre'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text"  id="apellido" class="form-control" name="apellido" value="<?php echo $usuario['apellido'];?>" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_nac">Fecha de Nacimiento:</label>
                                <input type="date" id="fechaN" class="form-control" name="fechaN" value="<?php echo $usuario['facha_nacimiento'];?>" required>
                            </div>
                            <div class="form-group">
                            <label for="dni">DNI:</label>
                            <input type="text" id="dni" class="form-control" name="dni"  value="<?php echo $usuario['DNI'];?>"require>
                            </div>
                            <div class="form-group">
                                  <label for="telefono" class="form-label">Telefono *</label>
                                <input type="tel"  id="telefono" name="telefono" class="form-control" value="<?php echo $usuario['Telefono'];?>"required>
                            </div>
                            <div class="form-group">
                                <label for="username">Correo:</label><br>
                                <input type="email" name="correo" id="correo" class="form-control" placeholder="" value="<?php echo $usuario['email_correo'];?>">
                            </div>
                            <div class="form-group">
                             <label for="direccion">Dirección:</label>
                             <input type="text" id="direccion" class="form-control" name="direccion" autocomplete="off" value="<?php echo $usuario['direccion'];?>"required>
                             </div>
                             <div class="form-group">
                        <label for="ciudad">Ciudad:</label>
                        <select name="ciudad" id="ciudad" class="form-control" autocomplete="off" value="<?php echo $usuario['ciudad'];?>"required>
                            <option selected>Seleccione una ciudad</option>
                            <!-- <option value="">Seleccione una ciudad</option> -->
                            <option value="Chimbas">Chimbas</option>
                            <option value="Rivadavia">Rivadavia</option>
                            <option value="Capital">Capital</option>
                            <option value="Santa Lucia">Santa Lucia</option>
                            <option value="Pocito">Pocito</option>
                            <option value="Rawson">Rawson</option>
                            <option value="9 de Julio">9 de Julio</option>
                            <option value="25 de Mayo">25 de Mayo</option>
                            <option value="Iglesia ">Iglesia</option>
                            <option value="Jachal">Jachal</option>
                            <option value="Valle Fértil">Valle Fértil</option>
                            <option value="Calingasta">Calingasta</option>
                            <option value="Ullum">Ullum</option>
                            <option value="Albardón">Albardón</option>
                            <option value="Angaco">Angaco</option>
                            <option value="Caucete">Caucete</option>
                            <option value="Zonda">Zonda</option>
                            <option value="San Martin">San Martin</option>
                            <option value="Sarmiento">Sarmiento</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="nacionalida">Nacionalidad:</label>
                        <input type="text" id="pais" class="form-control" name="pais" autocomplete="off" value="<?php echo $usuario['pais'];?>" required>
                        </div>
                            <div class="form-group">
                            <label for="genero">Genero:</label>
                           <select  id="genero" name="genero" aria-placeholder="Seleccione Rol" class="form-control" value="<?php echo $usuario['genero'];?>" required>
                          <option value="">Seleccione genero</option>
                          <option value="1">Masculino</option>
                         <option value="2">Femenino</option>
                           </select><br>
                            </div>
                           <div class="form-group">
                                <label for="fecha_nac">Fecha de Ingreso:</label>
                                <input type="date"  id="fechaI" class="form-control" name="fechaI" autocomplete="off" value="<?php echo $usuario['fecha_ingreso'];?>"required>
                                </div>
                            

                            <div class="form-group">
                                  <label for="rol" class="form-label">Rol de usuario *</label>
                                <input type="number"  id="rol" name="rol" class="form-control" placeholder="Escribe el rol, 1 admin, 2 lector.." value="<?php echo $usuario['id_rol'];?>" required>

                                  <input type="hidden" name="accion" value="editar_registro">
                                <input type="hidden" name="id" value="<?php echo $id;?>">
                            </div>
                        
                           <br>

                                <div class="mb-3">
                                    
                                <button type="submit" class="btn btn-success" >Editar</button>
                               <a href="user.php" class="btn btn-danger">Cancelar</a>
                               
                            </div>
                            </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</body>
</html>