<?php 
require 'navbar.php';
require '../../conn/connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicializar variables
$select_ciclo = null;
$selected_materia = null;
$alumnos = [];
$materias = [];
$ciclo = null;

// Obtener ciclo lectivo actual o seleccionado
try {
    if (!isset($_POST['buscar']) && !isset($_POST['guarda_nota'])) {
        $sql_ciclo = "SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1";
        $stmt = $db->query($sql_ciclo);
        $ciclo = $stmt->fetch(PDO::FETCH_ASSOC);
        $select_ciclo = $ciclo['id_ciclo'];
    }

    if (isset($_POST['buscar']) || isset($_POST['guarda_nota'])) {
        $select_ciclo = !empty($_POST['select_ciclo']) ? $_POST['select_ciclo'] : 
                       (!empty($_POST['ciclo_lectivo']) ? $_POST['ciclo_lectivo'] : null);
        $selected_materia = !empty($_POST['select_materia']) ? $_POST['select_materia'] : 
                          (!empty($_POST['materia_id']) ? $_POST['materia_id'] : null);
        
        if ($select_ciclo) {
            $sql_ciclo = "SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo WHERE id_ciclo = :id_ciclo";
            $stmt = $db->prepare($sql_ciclo);
            $stmt->execute(['id_ciclo' => $select_ciclo]);
            $ciclo = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $sql_ciclo = "SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1";
            $stmt = $db->query($sql_ciclo);
            $ciclo = $stmt->fetch(PDO::FETCH_ASSOC);
            $select_ciclo = $ciclo['id_ciclo'];
        }

        // Obtener alumnos de la materia y ciclo lectivo seleccionados
        if ($selected_materia && $select_ciclo) {
            $sql_alumnos = "SELECT DISTINCT p.*, am.id_materia 
                           FROM persona p 
                           JOIN alumno_materia am ON p.id_persona = am.id_persona 
                           WHERE am.id_materia = :materia_id
                           AND am.id_ciclo = :ciclo_id
                           ORDER BY p.apellido, p.nombre";
            $stmt = $db->prepare($sql_alumnos);
            $stmt->execute([
                'materia_id' => $selected_materia,
                'ciclo_id' => $select_ciclo
            ]);
            $alumnos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // Obtener todas las materias activas
    $sql_materias = "SELECT * FROM materia WHERE estado = 'Activo' ORDER BY Nombre";
    $stmt_materias = $db->query($sql_materias);
    $materias = $stmt_materias->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Manejo silencioso del error
}

// Procesar guardado de notas
if (isset($_POST['guarda_nota'])) {
    $alumno_id = $_POST["alumno_id"];
    $materia_id = $_POST["materia_id"];
    $ciclo_lectivo = $_POST["ciclo_lectivo"];    
    
    // Obtener las notas del form
    $notas = [];
    for ($i = 1; $i <= 13; $i++) {
        if ($i != 8) {
            $nota = isset($_POST["n$i"]) ? $_POST["n$i"] : null;
            $notas["n$i"] = !empty($nota) && is_numeric($nota) ? (float)$nota : null;
        }
    }

    try {
        // Verificar si ya existe la nota
        $sql_nota = "SELECT * FROM nota WHERE id_persona = ? AND id_materia = ? AND id_ciclo = ?";
        $stmt = $db->prepare($sql_nota);
        $stmt->execute([$alumno_id, $materia_id, $ciclo_lectivo]);
        $nota_existente = $stmt->fetch();

        if ($nota_existente && $nota_existente['estado'] === 'activo') {
            // Actualizar nota existente
            $sql = "UPDATE nota SET " . 
                   implode(', ', array_map(function($key) { return "$key = :$key"; }, array_keys($notas))) .
                   " WHERE id_persona = :alumno_id AND id_materia = :materia_id AND id_ciclo = :ciclo_lectivo";
        } else {
            // Insertar nueva nota
            $estado = 'activo';
            $sql = "INSERT INTO nota (id_persona, id_materia, id_ciclo, " . implode(', ', array_keys($notas)) . ", estado) 
                    VALUES (:alumno_id, :materia_id, :ciclo_lectivo, " . 
                    implode(', ', array_map(function($key) { return ":$key"; }, array_keys($notas))) . 
                    ", :estado)";
        }

        $stmt = $db->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':alumno_id', $alumno_id);
        $stmt->bindParam(':materia_id', $materia_id);
        $stmt->bindParam(':ciclo_lectivo', $ciclo_lectivo);
        if (!$nota_existente) {
            $stmt->bindParam(':estado', $estado);
        }
        foreach ($notas as $key => $value) {
            $stmt->bindParam(":$key", $notas[$key]);
        }
        
        $stmt->execute();
        
       
              
    } catch (PDOException $e) {
        // Manejo silencioso del error
    }
}
?>    

<section class="content mt-3">
    <div class="row m-auto">
        <div class="col-sm">
            <div class="card rounded-2 border-0">
                <div class="card-header bg-dark text-white pb-0">    
                    <div class="row">                
                        <div class="col">
                            <h5>Gestión de Notas</h5>
                        </div>
                        <div class="col-md-8">
                            <form id="searchForm" action="" method="post" class="form-inline justify-content-end my-1">
                                <div class="row g-3 align-items-center w-100">
                                    <div class="col-auto">
                                        <select name="select_ciclo" class="form-control form-control-sm" required>
                                            <option value="">Seleccione ciclo lectivo</option>
                                            <?php                          
                                            $stmt = $db->query("SELECT * FROM ciclo_lectivo ORDER BY nombre_ciclo DESC");
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $selected = ($row["id_ciclo"] == $select_ciclo) ? 'selected' : '';
                                                echo "<option value='{$row["id_ciclo"]}' {$selected}>{$row["nombre_ciclo"]}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <select name="select_materia" class="form-control form-control-sm" required>
                                            <option value="">Seleccione materia</option>
                                            <?php
                                            foreach ($materias as $materia) {
                                                $selected = ($materia["id_materia"] == $selected_materia) ? 'selected' : '';
                                                echo "<option value='{$materia["id_materia"]}' {$selected}>{$materia["Nombre"]}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" name="buscar" class="btn btn-primary btn-sm">Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>             
                    </div>
                </div>

                <div class="card-body table-responsive">
                    <?php if (!empty($alumnos)): ?>
                        <table id="" class="table table-striped table-sm">
                            <thead class="thead-dark"> 
                                <tr>        
                                    <th id="fixed-size2">N°</th>
                                    <th id="fixed-size3">Alumno</th>  
                                    <th id="fixed-size2">DNI</th>           
                                    <?php   
                                    $sql_examen = "SELECT * FROM examen WHERE id_examen_tipo <> 8";
                                    $stmt_examen = $db->query($sql_examen);
                                    $examenes = $stmt_examen->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($examenes as $examen) {
                                        echo '<th id="fixed-size">'. htmlspecialchars($examen['nombre_examen']) .'</th>';
                                    }
                                    ?>                                                               
                                    <th id="fixed-size">Guardar</th>
                                </tr>
                            </thead>
                            <tbody>                            
                                <?php foreach ($alumnos as $index => $alumno): ?>
                                    <tr>
                                        <form action="" method="post">
                                            <input type="hidden" name="alumno_id" value="<?php echo htmlspecialchars($alumno['id_persona']); ?>">
                                            <input type="hidden" name="materia_id" value="<?php echo htmlspecialchars($selected_materia); ?>">
                                            <input type="hidden" name="ciclo_lectivo" value="<?php echo htmlspecialchars($select_ciclo); ?>">
                                            
                                            <td id="fixed-size2"><?php echo $index + 1; ?></td>
                                            <td id="fixed-size3"><?php echo htmlspecialchars($alumno['apellido'] . ', ' . $alumno['nombre']); ?></td>
                                            <td id="fixed-size2"><?php echo htmlspecialchars($alumno['DNI']); ?></td>
                                            
                                            <?php
                                            // Obtener notas existentes
                                            $sql_nota = "SELECT * FROM nota 
                                                       WHERE id_persona = ? 
                                                       AND id_materia = ?
                                                       AND id_ciclo = ?";
                                            $stmt = $db->prepare($sql_nota);
                                            $stmt->execute([$alumno['id_persona'], $selected_materia, $select_ciclo]);
                                            $nota = $stmt->fetch(PDO::FETCH_ASSOC);

                                            // -------------------------                                       
                                        if(empty($nota['n1'])){$nota1 =null;}else{$nota1= $nota['n1'];}
                                        if(empty($nota['n2'])){$nota2 =null;}else{$nota2= $nota['n2'];}
                                        if(empty($nota['n3'])){$nota3 =null;}else{$nota3= $nota['n3'];}
                                        if(empty($nota['n4'])){$nota4 =null;}else{$nota4= $nota['n4'];}
                                        if(empty($nota['n5'])){$nota5 =null;}else{$nota5= $nota['n5'];}
                                        if(empty($nota['n6'])){$nota6 =null;}else{$nota6= $nota['n6'];}
                                        if(empty($nota['n7'])){$nota7 =null;}else{$nota7= $nota['n7'];}
                                        if(empty($nota['n8'])){$nota8 =null;}else{$nota8= $nota['n8'];}
                                        if(empty($nota['n9'])){$nota9 =null;}else{$nota9= $nota['n9'];}
                                       if(empty($nota['n10'])){$nota10=null;}else{$nota10= $nota['n10'];}
                                       if(empty($nota['n11'])){$nota11=null;}else{$nota11= $nota['n11'];}
                                       if(empty($nota['n12'])){$nota12=null;}else{$nota12= $nota['n12'];}                                        
                                       if(empty($nota['n13'])){$nota13=null;}else{$nota13= $nota['n13'];}
                                        // -----------------------------------------------
                                        $notas = [$nota1, $nota2, $nota3, $nota4];
                                        $notas_filtradas = array_filter($notas, function($nota) {
                                            return !is_null($nota) && $nota !== 0 && $nota !== '';
                                        });
                                        if (count($notas_filtradas) > 0) {
                                            $nota5 = array_sum($notas_filtradas) / count($notas_filtradas);
                                        } 
                                        $nota13 = max($nota6, $nota7, $nota8, $nota9, $nota10, $nota11, $nota12);
                                        if (!($nota13 >= 4)){
                                            $nota13=null;
                                        }
                                        ?>
                                        
                                        <!-- -------------------------------------------------- -->
                                        <td><input id="fixed-size"  name="n1"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota1; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n2"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota2; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n3"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota3; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n4"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota4; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n5"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota5; ?>" placeholder="" class="form-control" readonly></td> 
                                        <td><input id="fixed-size"  name="n6"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota6; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n7"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota7; ?>" placeholder="" class="form-control"></td> 
                                        <!-- <td><input id="fixed-size"  name="n8"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota8; ?>" placeholder="" class="form-control" readonly></td>  -->
                                        <td><input id="fixed-size"  name="n9"  type="number" min="0" max="10" step="0.1" value="<?php echo $nota9; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n10" type="number" min="0" max="10" step="0.1" value="<?php echo $nota10; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n11" type="number" min="0" max="10" step="0.1" value="<?php echo $nota11; ?>" placeholder="" class="form-control"></td> 
                                        <td><input id="fixed-size"  name="n12" type="number" min="0" max="10" step="0.1" value="<?php echo $nota12; ?>" placeholder="" class="form-control"></td>                                         
                                        <td><input id="fixed-size"  name="n13" type="number" min="0" max="10" step="0.1" value="<?php echo $nota13; ?>" placeholder="" class="form-control" readonly></td> 
                                        <td>
                                           <button type="submit" name="guarda_nota" class="btn btn-primary btn-sm" >Guardar</button>
                                        </td>
                                        </form>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <?php if ($selected_materia): ?>
                                No hay alumnos inscritos en esta materia para el ciclo lectivo seleccionado.
                            <?php else: ?>
                                Seleccione un ciclo lectivo y una materia para ver los alumnos.
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>    
            </div> 
        </div>   
    </div>
</section>

<?php require 'footer.php'; ?>