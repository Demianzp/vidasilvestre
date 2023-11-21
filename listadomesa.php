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
<?php require 'navbar.php'; ?>
<!doctype html>
<html lang="en">
 

    
  <body> 
       
  <div class="container mt-3">
        <div class="card rounded-2 border-0">
            <h5 class="card-header bg-dark text-white"> Mesas de Examen <a href="fpdf/rep-mesa.php" tanget="_blank" class="btn btn-outline-danger  float-right mb-2" > <i class="fas fa-file-excel"></i>PDF</a>
          <a href="fpdf/excel.php" tanget="_blank" class="btn btn-outline-success float-right mb-2" > <i class="fas fa-file-excel"></i>EXCEL</a></h5>
         
            <div class="card-body bg-light">
           
            <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
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
    </div>

    
  </body>
</html>
