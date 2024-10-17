<?php
require '../../conn/connection.php';

if (isset($_GET['id'])) {
    $id_alumno = $_GET['id'];
    $consulta_alumno = $db->prepare("SELECT * FROM persona WHERE id_persona = :id");
    $consulta_alumno->bindParam(':id', $id_alumno, PDO::PARAM_INT);
    $consulta_alumno->execute();
    $alumno = $consulta_alumno->fetch();

    if (!$alumno) {
        die('No se encontró el alumno con el ID proporcionado.');
    }
} else {
    die('Ha ocurrido un error');
}
?>
   <!-- CSS en línea dentro del archivo PHP -->
   
<?php require 'navbar.php'; ?>

      <body>
        
    
    <div class="container mt-3">
        <div class="row m-auto">
            <div class="col-sm">
                <div class="card rounded-2 border-0">
                    <!-- Aquí puedes agregar el logo y otros datos que quieras que se muestren para la impresión -->
                    <div class="text-center mb-4">
                        <br>
                        <img src="../../img/LOGO.png" alt="Logo" style="max-width: 50px;">
                        <h5>Instituto Superior Vida Silvestre</h5>
                    </div>

                    <div class="card-body bg-light">
                        <div class="form-group">
                            <label><strong>Nombres y Apellidos:</strong></label>
                            <p><?php echo htmlspecialchars($alumno['nombre']); ?>  <?php echo htmlspecialchars($alumno['apellido']); ?></p>
                        </div>
                        <div class="form-group">
                            <label><strong>DNI:</strong></label>
                            <p><?php echo htmlspecialchars($alumno['DNI']); ?></p>

                            <label><strong>Fecha de nacimiento:</strong></label>
                            <p><?php echo htmlspecialchars($alumno['fecha_nacimiento']); ?></p>

                        </div>

                      
                        <div class="form-group">
                            
                        <label><strong>País:</strong></label>
                            <p><?php echo htmlspecialchars($alumno['pais']); ?></p>

                            <label><strong>Departamento:</strong></label>
                            <p><?php echo htmlspecialchars($alumno['ciudad']); ?></p>

                            <label><strong>Dirección:</strong></label>
                            <p><?php echo htmlspecialchars($alumno['direccion']); ?></p>


                        </div>


                        <div class="form-group">
                            <label><strong>Correo:</strong></label>
                            <p><?php echo htmlspecialchars($alumno['email_correo']); ?></p>
                        </div>
                        <div class="form-group">
                            <label><strong>Celular:</strong></label>
                            <p><?php echo htmlspecialchars($alumno['celular']); ?></p>
                        </div>
                        <br>
                        <div class="mt-3">
                            <a class="btn btn-warning" href="alumno_index.php">Regresar al Listado</a>
                            <button class="btn btn-primary" onclick="window.print()">Imprimir</button>   
                            <p class="nota" style="font-size: 12px; color: gray;">Nota: Asegúrate de que la opción "Imprimir encabezados y pies de página" esté desactivada en tu configuración de impresión para no mostrar la dirección del navegador.</p>                      
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </div>
   
   

</body>
<style>
@media print {
    /* Ajusta los márgenes de la página */
    @page {
        margin: 10mm;
    }

    body {
        margin: 0;
        padding: 0;
        font-size: 12px; /* Ajusta el tamaño de la fuente */
    }

    /* Oculta elementos innecesarios para la impresión */
    .btn, .navbar, .footer, .nota {
        display: none;
    }

    img {
        max-width: 100px; /* Ajusta el tamaño del logo */
        margin-bottom: 10px; /* Añadir algo de espacio entre el logo y el título */
    }

    h5, p {
        text-align: center; /* Centra los títulos y párrafos para un mejor formato */
    }

    /* Elimina bordes innecesarios */
    .card {
        border: none;
    }

    .form-group {
        margin-bottom: 5px; /* Reduce el espacio entre los elementos */
    }

    label {
        font-weight: bold;
        margin-right: 5px;
        display: inline-block; /* Asegura que las etiquetas estén en línea */
    }

    p {
        display: inline-block;
        margin: 0;
    }

    .container {
        width: 100%; /* Usa todo el ancho disponible */
        padding: 0;
    }

    /* Opcional: Ajusta el tamaño de los elementos */
    .form-group p {
        font-size: 12px; /* Tamaño del texto de los párrafos */
    }
}
</style>
