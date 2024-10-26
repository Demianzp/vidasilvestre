<?php require 'navbar.php'; ?>
<div class="container mt-4">
    <div class="panel">
        <?php
        if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === true) {
            // Usuario autenticado, mostrar el contenido protegido
            echo "<div class='alert alert-success'>Bienvenido, usuario autenticado.</div>";
        } else {
            // Si el usuario no ha iniciado sesión, mostrar el formulario de inicio de sesión y mensajes de error si las credenciales son incorrectas
            if (isset($_GET['err']) && $_GET['err'] == 1) {
                echo "<div class='alert alert-danger'>Credenciales incorrectas. Por favor, inténtalo de nuevo.</div>";
            }
        }
        ?>
        <h1 class="text-center mb-1">Centro Escolar Inicio</h1>
    </div>

    <!-- Panel para mostrar mensajes -->
    <div class="card mt-4">
        <div class="card-header">
            <h2 class="mb-0">Mensajes Recibidos</h2>
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">Mensaje 1: [Contenido del mensaje]</li>
                <li class="list-group-item">Mensaje 2: [Contenido del mensaje]</li>
                <li class="list-group-item">Mensaje 3: [Contenido del mensaje]</li>
                <!-- Aquí se pueden agregar dinámicamente los mensajes -->
            </ul>
        </div>
    </div>
</div>
<?php require 'footer.php'; ?>
