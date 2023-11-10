<!DOCTYPE html>
<html lang="es">
<head>
    
    <!-- ... (tu código actsual) ... -->
</head>
<body>
    <?php require 'navbar.php'; ?>

    <div class="container mt-2 " style="width: 40rem">
        <div class="row m-auto">
            <div class="col ">
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white ">Registro de Materias</h5>
                    <div class="card-body">
                        
                        <form action="procesar_materia.php" method="post" id="materiaForm">
                      
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" data-name="Nombre" name="nombre" id="nombre" placeholder="Ingrese el Nombre" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción:</label>
                                <input type="text" class="form-control" data-name="Descripción" name="descripcion" placeholder="Ingrese Descripcion" id="descripcion">
                            </div>
                            <div class="form-group">
                                <label for="horas">Horas de cursada:</label>
                                <input type="text" class="form-control" data-name="Horas de cursada" name="horas" id="horas" required placeholder="Ingrese las horas" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="anio">Año de Cursado:</label>
                                <input type="number" class="form-control" data-name="Año de Cursado" name="año" id="año" placeholder="Ingrese año de Cursado" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="num_resolucion">Número de Resolución:</label>
                                <input type="text" class="form-control" data-name="Número de Resolución" id="num_resolucion" name="num_resolucion" placeholder="Ingrese N° de Resolucion" required autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="plan_estudio">Plan de Estudio</label>
                                <input type="text" class="form-control" data-name="Plan de Estudio" id="plan_estudio" name="plan_estudio" placeholder="Ingrese Plan de estudio" autocomplete="off" required>
                            </div>
                            <div class="form-group">
                                <label for="tipo">Tipo de Materia:</label>
                                <select name="tipo" class="form-control" autocomplete="off" required>
                                    <option value="" disabled selected>Seleccione su Tipo</option>
                                    <option value="1">Promocional</option>
                                    <option value="2">Regular</option>
                                    <option value="3">Libre</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="validarCampos()">Continuar</button>
                        </form>

                        <div id="datosIngresados" style="display: none;">
                            <h5 class="mt-3">Datos Ingresados:</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Campo</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se mostrarán los datos ingresados -->
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success" onclick="registrarMateria()">Registrar</button>
                            <a href="listado_materia.php?mensajeCancelacion=<?= urlencode('Se canceló la carga de materia') ?>" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php require 'footer.php'; ?>
    <script src="js/materia.js"></script>
</body>

</html>
