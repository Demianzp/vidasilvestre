<?php require 'conn/connection.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Mesa de Examen</title>
</head>
<body>
<?php require 'navbar.php'; ?>
    
</body>
</html>



<div class="container mt-3">
        <div class="card rounded-2 border-0">
            <h5 class="card-header bg-dark text-white">Agregar Mesa de Examen</h5>
            <div class="card-body bg-light">
                <form action="procesar_mesa.php" method="post">
                    <label for="materia">Materia:</label>
                    <select name="materia" id="materia" class="form-control" autocomplete="off" required>
                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['id_materia'] . "'>" . $row['nombre'] . "</option>";
                        }
                        ?>
                    </select>
                    <br>
                    <label for="fecha">Fecha:</label>
                    <input type="date" name="fecha" required>
                    <br>
                    <label for="hora">Hora:</label>
                    <input type="time" name="hora" required>
                    <br>
                    <label for="tipo">Tipo:</label>
                    <input type="text" name="tipo" required>
                    <br>
                    <input type="submit" value="Agregar Mesa">
                </form>
            
            </div>
        </div>
    </div>
