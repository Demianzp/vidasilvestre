<?php
// Habilitar la visualización de errores para detectar problemas
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('../../conn/connection.php');

if (isset($_POST['id_mesa'])) {
    $id_mesa = $_POST['id_mesa'];

    // Obtener los resultados de los alumnos
    $query = "
        SELECT dni, ape_nom, escrito, oral, definitivo, asistencia FROM acta WHERE acta.id_mesa = :id_mesa";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':id_mesa', $id_mesa, PDO::PARAM_INT);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si se encontraron resultados
    if (empty($resultados)) {
        echo "No se encontraron resultados para esta mesa.";
        exit; // Detener la ejecución si no hay resultados
    }
    // Inicializar contadores
    $total_alumnos = count($resultados);
    $aprobados = 0;
    $desaprobados = 0;
    $ausentes = 0;

       
    foreach ($resultados as $resultado) {
        $definitivo = $resultado['definitivo'] ?? null;
        $asistencia = strtolower($resultado['asistencia']); 

        if ($asistencia === 'ausente') {
            $ausentes++;
        } elseif ($asistencia === 'presente') {
            if ($definitivo !== null && $definitivo >= 6) { 
                $aprobados++;
            } else {
                $desaprobados++;
            }
        }
    }
    require 'navbar.php';
?>

<section class="content mt-3">
    <div class="container">
        <div class="card rounded-2 border-0">
            <div class="card-header pb-0 bg-dark text-white">
                <h4 class="d-inline-block">Acta de Exámenes</h4>
                
                    <!-- Botón para imprimir -->
                <button id="printButton" class="btn btn-primary float-right mb-2" type="button">Imprimir</button>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div>
                        <p>Establecimiento: ..........................................................................................................................................................................................................................................................................................................................................</p> <br>
                        <p>ACTA DE EXÁMENES DE ALUMNOS: ..................................................................................................................................................................................................................................................................................................</p>
                        <p>de:......................................................................................................................................................................................................................................................................................................................................................................</p><br>
                        <p>Correspondientes al:......................................................................................................año de estudios.</p><br>
                        <p>
                            A los.................................días del mes de.............................. del año .........................de dos mil ....................
                                 </p><br>
                        <p>Reunida la Comisión Examinadora de la asignatura mencionada, con asistencia de sus tres miembros Señores/as:.......................................................................................................................................
                        ............................................................................................................................................................................................................................................................................................................................................................................</p>
                        <p>Procedió a cumplir su cometido con el resultado que se aconsigna a contuniación:</p>
                    </div>

                    <!-- Tabla con los datos -->
                    <table class="table table-striped table-bordered"  cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo y N° de Documento</th>
                                <th>Apellido y Nombre</th>
                                <th>Examen Escrito</th>
                                <th>Examen Oral</th>
                                <th>Calificación Definitiva</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $i = 1;
                            foreach ($resultados as $resultado): 
                                $definitivo = $resultado['definitivo'] ?? '';
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($resultado['dni']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['ape_nom']); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['escrito'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($resultado['oral'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($definitivo); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Resumen -->
                    <p>
                    <p>
                        Se hace constar que, sobre un total de <b><?php echo $total_alumnos; ?></b> alumnos, resultaron 
                        <b><?php echo $aprobados; ?></b> aprobados, <b><?php echo $desaprobados; ?></b> desaprobados, y 
                        <b><?php echo $ausentes; ?></b> ausentes.
                        .........................................................................................................................................................................................................................................................................................................................................................................
                        .........................................................................................................................................................................................................................................................................................................................................................................
                        .........................................................................................................................................................................................................................................................................................................................................................................
                  
                    </p><br>

                    <br><br>
                    <h6>
                    .............................................................................<br>
                        Firma del Presidente
                    </h6> <br>

                    <h6>
                    .............................................................................<br>
                        Firma del Vocal
                    </h6>
<br>
                    <h6>
                    .............................................................................<br>
                        Firma del Secretario
                    </h6>

                </form>
            </div>
        </div>
    </div>  
</section>

<!-- Script para manejar la impresión -->
<script>
    document.getElementById("printButton").addEventListener("click", function() {
        window.print();
    });
</script>

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

    h6 {
        text-align: right; /* Centra los títulos y párrafos para un mejor formato */


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
        margin: 10;
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

<?php } ?>
