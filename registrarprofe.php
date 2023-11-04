
<!DOCTYPE html>
<html>

<head>
    <title>Formulario de Inscripción de Alumno</title>
    <!-- Agrega el enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>



<body>
    <?php require 'navbar.php'; ?>
    <div class="container mt-3">
        <div class="card rounded-2 border-0">
            <h5 class="card-header bg-dark text-white">Formulario de Inscripción de Profesor</h5>
            <div class="card-body bg-light ">
                <form method="post" action="procesar_formulario.php">
                    <!-- --------------------------- -->
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nombre1">Nombre:</label>
                                <input type="text" class="form-control" name="nombre1"autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="apellido1">Apellido:</label>
                                <input type="text" class="form-control" name="apellido1"autocomplete="off" required>
                            </div>
                        </div>                        
                    </div>
                    <!-- --------------------------- -->
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <input type="text" class="form-control" name="dni" autocomplete="off" required>
                    </div>                    
                    <!-- --------------------------- -->
                    <div class="form-group">
                        <label for="celular">Celular:</label>
                        <input type="tel" class="form-control" name="celular" autocomplete="off" require>
                    </div>
                    <!-- --------------------------- -->
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" name="email" autocomplete="off" required>
                    </div>
                    <!-- --------------------------- -->
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" name="direccion" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="col">
                            <label for="ciudad">Ciudad:</label>
                            <select name="ciudad" id="ciudad" class="form-control" autocomplete="off" required>
                                <option value="">Seleccione una ciudad</option>
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
                    </div>
                    <!-- --------------------------- -->
                    
                    <!-- --------------------------- -->
                    
                    <br>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    <?php require 'footer.php'; ?>
</body>

</html>