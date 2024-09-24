<?php
require 'navbar.php';
require '../../conn/connection.php';

$alumno_id = $_GET['id'] ?? null;
if (!$alumno_id) {
    die("ID de alumno no especificado.");
}

// Fetch student info
$stmt = $db->prepare("SELECT CONCAT(nombre, ' ', apellido) AS nombre_completo FROM persona WHERE id_persona = ?");
$stmt->execute([$alumno_id]);
$nombre_completo = $stmt->fetchColumn() ?: "Alumno no encontrado";

// Fetch active subjects
$stmt = $db->query("SELECT * FROM materia WHERE estado = 'Activo'");
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle grade submission
if (isset($_POST['guarda_nota'])) {
    $stmt = $db->prepare("INSERT INTO nota (id_persona, id_materia, id_ciclo, n1, n2, n3, n4, n5, n6, n7, n8, n9, n10, n11, n12, n13, estado) 
                          VALUES (:id_persona, :id_materia, :ciclo_lectivo, :n1, :n2, :n3, :n4, :n5, :n6, :n7, :n8, :n9, :n10, :n11, :n12, :n13, 'activo')
                          ON DUPLICATE KEY UPDATE 
                          n1=:n1, n2=:n2, n3=:n3, n4=:n4, n5=:n5, n6=:n6, n7=:n7, n8=:n8, n9=:n9, n10=:n10, n11=:n11, n12=:n12, n13=:n13");
    $stmt->execute($_POST);
}

// Fetch current academic cycle
$select_ciclo = $_POST['select_ciclo'] ?? null;
if (!$select_ciclo) {
    $stmt = $db->query("SELECT id_ciclo, nombre_ciclo FROM ciclo_lectivo WHERE ciclo_actual = 1 LIMIT 1");
    $ciclo = $stmt->fetch(PDO::FETCH_ASSOC);
    $select_ciclo = $ciclo['id_ciclo'];
}

// Fetch exam types
$stmt = $db->query("SELECT * FROM examen");
$examenes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="content mt-3">
    <div class="card rounded-2 border-0">
        <div class="card-header bg-dark text-white pb-0">
            <div class="row">
                <h5 class="col"><?= htmlspecialchars($nombre_completo) ?></h5>
                <div class="col mb-2">
                    <form id="miFormulario" action="" method="post" class="form-inline justify-content-end my-1">
                        <select name="select_ciclo" class="form-control form-control-sm w-50" onchange="this.form.submit()">
                            <option value="" disabled selected>Ciclo lectivo actual: <?= $ciclo['nombre_ciclo'] ?></option>
                            <?php
                            $stmt = $db->query("SELECT * FROM ciclo_lectivo");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row["id_ciclo"]}'>{$row["nombre_ciclo"]}</option>";
                            }
                            ?>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table id="nota" class="table table-striped table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Materia</th>
                        <?php foreach ($examenes as $examen): ?>
                            <th><?= htmlspecialchars($examen['nombre_examen']) ?></th>
                        <?php endforeach; ?>
                        <th>Guardar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($materias as $index => $materia): 
                        $stmt = $db->prepare("SELECT * FROM nota WHERE id_persona = ? AND id_materia = ? AND id_ciclo = ?");
                        $stmt->execute([$alumno_id, $materia['id_materia'], $select_ciclo]);
                        $nota = $stmt->fetch(PDO::FETCH_ASSOC);
                    ?>
                        <tr>
                            <form action="" method="post">
                                <input type="hidden" name="id_persona" value="<?= $alumno_id ?>">
                                <input type="hidden" name="id_materia" value="<?= $materia['id_materia'] ?>">
                                <input type="hidden" name="ciclo_lectivo" value="<?= $select_ciclo ?>">
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($materia['Nombre']) ?></td>
                                <?php for ($i = 1; $i <= 13; $i++): ?>
                                    <td><input type="text" name="n<?= $i ?>" value="<?= $nota["n$i"] ?? '' ?>" class="form-control"></td>
                                <?php endfor; ?>
                                <td>
                                    <button type="submit" name="guarda_nota" class="btn btn-primary btn-sm">Guardar</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>