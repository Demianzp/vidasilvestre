<?php
ob_start();
?>


<?php
// Incluye el archivo de conexión
require 'conn/connection.php';

// Realiza la consulta para obtener las mesas de examen
$query = "SELECT mesa_examen.*, 
                 materia.nombre AS nombre_materia, 
                 ciclo_lectivo.nombre_ciclo,
                 nombre_tipo AS nombre_tipo
          FROM mesa_examen 
          INNER JOIN materia ON mesa_examen.id_materia = materia.id_materia
          LEFT JOIN ciclo_lectivo ON mesa_examen.id_ciclo = ciclo_lectivo.id_ciclo
          LEFT JOIN tipo ON mesa_examen.id_tipo = tipo.id_tipo";
$result = $db->query($query);

?>
<!DOCTYPE html>
<html>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">   
<!-- ------------DATATABLES----- -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script defer src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script defer src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script defer src="js/tabla.js"></script>
<!-- ------------FIN-DATATABLES----- -->
    <title>Reporte</title>

</head>
<body>
<img src="img/b.svg" class="rounded float-start" alt="..."> 
    <div class="container mt-3">
        <div class="card rounded-2 border-0">
            <h5 class="card-header bg-dark text-white">Reporte</h5>
            <div class="card-body bg-light">
                   <table id="tabla" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre de Mesa</th>
                            <th>Materia</th>
                            <th>Hora</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Ciclo Lectivo</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row['nombre_mesa'] . "</td>";
                            echo "<td>" . $row['nombre_materia'] . "</td>";
                            echo "<td>" . $row['hora'] . "</td>";
                            echo "<td>" . $row['fecha'] . "</td>";
                            echo "<td>" . $row['fecha_fin'] . "</td>";
                            echo "<td>" . $row['nombre_ciclo'] . "</td>";
                            echo "<td>" . $row['nombre_tipo'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
                
        </div>
    </div>

</body>
</html>
<?php
$html= ob_get_clean();
//echo $html;
require_once 'libreria/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf(); 

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled'=> true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);
//$dompdf-->setPaper('letter'); 
$dompdf->setPaper('A4', 'landscape'); 

$dompdf->render();

$dompdf->stream("informe.pdf", array("Attachment"=>false));

?>