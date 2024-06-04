
<?php require 'navbar.php'; ?>
    <div class="container mt-2 " >        
                <div class="card rounded-2 border-0">
                    <h5 class="card-header bg-dark text-white ">Registro de Materias</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <form action="procesar_materia.php" method="post" id="materiaForm">
                                    <div class="form-group">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" data-name="Nombre" name="nombre" id="nombre" placeholder="Ingrese el Nombre"  autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripción:</label>
                                        <input type="text" class="form-control" data-name="Descripción" name="descripcion" placeholder="Ingrese Descripcion" id="descripcion"  autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="horas">Horas de cursada:</label>
                                        <input type="text" class="form-control" data-name="Horas de cursada" name="horas" id="horas"  placeholder="Ingrese las horas" autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="num_resolucion">Número de Resolución:</label>
                                        <input type="text" class="form-control" data-name="Número de Resolución" id="num_resolucion" name="num_resolucion" placeholder="Ingrese N° de Resolucion"  autocomplete="off" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="año">Año de Cursado:</label>
                                        <select name="año" id="año" class="form-control" autocomplete="off" required >
                                            <option value="" disabled selected>Seleccione Año de Cursado</option>
                                            <option value="1">1° Año</option>
                                            <option value="2">2° Año</option>
                                            <option value="3">3° Año</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="plan_estudio">Cuatrimestre</label>
                                        <select name="plan_estudio"   id="plan_estudio" class="form-control" autocomplete="off" required >
                                            <option value="" disabled selected>Seleccione el Cuatrimestre</option>
                                            <option value="1">1° Cuatrimestre</option>
                                            <option value="2">2° Cuatrimestre</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_tipo">Tipo de Materia:</label>
                                        <select name="id_tipo" class="form-control" autocomplete="off" required >
                                            <option value="" disabled selected>Seleccione su Tipo</option>
                                            <option value="1">Promocional</option>
                                            <option value="2">Regular</option>
                                            <option value="3">Libre</option>
                                        </select>
                                    </div>
                                    
                            </div>
                            <!-- -------------------------------------------------------- -->
                            <div class="col">
                                <div class="form-group">
                                            <label for="nombre">Correlativa</label>
                                            <input type="text" class="form-control" data-name="Nombre" name="nombre" id="nombre" placeholder="Ingrese el Nombre"  autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="descripcion">Correlativa</label>
                                            <input type="text" class="form-control" data-name="Descripción" name="descripcion" placeholder="Ingrese Descripcion" id="descripcion"  autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="horas">Correlativa</label>
                                            <input type="text" class="form-control" data-name="Horas de cursada" name="horas" id="horas"  placeholder="Ingrese las horas" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Correlativa</label>
                                            <input type="text" class="form-control" data-name="Número de Resolución" id="num_resolucion" name="num_resolucion" placeholder="Ingrese N° de Resolucion"  autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Correlativa</label>
                                            <input type="text" class="form-control" data-name="Número de Resolución" id="num_resolucion" name="num_resolucion" placeholder="Ingrese N° de Resolucion"  autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Correlativa</label>
                                            <input type="text" class="form-control" data-name="Número de Resolución" id="num_resolucion" name="num_resolucion" placeholder="Ingrese N° de Resolucion"  autocomplete="off" required>
                                        </div>
                                        
                                  <!-- ----------------------------------------------       -->
                                <button type="button" class="btn btn-primary" onclick="validarCampos()">Continuar</button>
                                        <a type="button" class="btn btn-danger" href="materia_index.php">Cancelar</a>
                                    </form>
                            </div>
                        </div>                        
                        <!-- ----------------------------------------------------------------- -->
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
                            <a href="materia_index.php?mensajeCancelacion=<?= urlencode('Se canceló la carga de materia') ?>" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>
                </div>
            
    </div>
    <script src="../../js/materia.js"></script>
<?php require 'footer.php'; ?>