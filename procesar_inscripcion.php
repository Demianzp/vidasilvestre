<?php
// procesar_inscripcion.php
require 'conn/connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si se han seleccionado alumnos
    if (isset($_POST['alumnos']) && is_array($_POST['alumnos']) && !empty($_POST['alumnos'])) {
        $ciclos = $db->prepare("SELECT * FROM ciclo_lectivo");
        $ciclos->execute();
        $ciclos = $ciclos->fetchAll();

        // Consulta de Materias (se ha movido fuera del bloque if)
        $materias = $db->prepare("SELECT * FROM materia");
        $materias->execute();
        $materias = $materias->fetchAll();
        ?>
        <!-- <!DOCTYPE html>
        <html lang="es"> -->
<!-- 
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Elegir Materia y Ciclo Lectivo</title>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        </head> -->
        <?php require 'navbar.php'; ?>
        <body>
            

            <section class="content mt-3">
                <div class="row m-auto">
                    <div class="col-sm">
                        <div class="card rounded-2 border-0">
                            <div class="card-header pb-0 bg-dark text-white ">
                                <h5 class="d-inline-block ">Elegir Materia y Ciclo Lectivo</h5>
                            </div>
                            <div class="card-body">
                                <form action="procesa_inscripcion2.php" method="post">
                                    <input type="hidden" name="alumnos" value="<?= implode(",", $_POST['alumnos']) ?>">
                                    <label class="font-weight-bold">Seleccione la Materia</label><br>
                                    <select class="form-select" name="materia" required>
                                        <?php foreach ($materias as $materia) : ?>
                                            <option value="<?= $materia['id_materia'] ?>"><?= $materia['Nombre'] ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                    <li class="list-group-item">
                                        <label for="ciclo">Ciclo Lectivo:</label>
                                        <select class="form-select" name="ciclo" required>
                                            <?php foreach ($ciclos as $ciclo) : ?>
                                                <option value="<?= $ciclo['id_ciclo'] ?>"><?= $ciclo['nombre_ciclo'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>

                                    <button type="submit" class="btn btn-primary">Inscribir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php require 'footer.php'; ?>
        </body>
        <?php
        exit();
    }
} else {
    // Si no es una solicitud POST, redirige a la página de alumnos
    header("Location: listadoalumnos.view.php");
    exit();
}

?>