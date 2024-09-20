<?php
session_start();
require 'navbar.php';
include('../../conn/connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica si el ID de la persona está en la sesión
if (!isset($_SESSION['id_persona']) || empty($_SESSION['id_persona'])) {
    die('Error: No se ha encontrado el ID de la persona en la sesión.');
}

$id_persona = $_SESSION['id_persona'];

function verificarContrasenaActual($db, $id_persona, $contrasena_actual)
{
    $stmt = $db->prepare("SELECT contraseña FROM persona WHERE id_persona = ?");
    $stmt->execute([$id_persona]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    return $usuario && $contrasena_actual === $usuario['contraseña'];
}

function mostrarMensaje($tipo, $titulo, $texto)
{
    echo '<script>
        Swal.fire({
            icon: "' . $tipo . '",
            title: "' . $titulo . '",
            text: "' . $texto . '"
        });
    </script>';
}

function procesarFormulario($db, $id_persona)
{
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $direccion = $_POST['direccion'];
    $contrasena_actual = $_POST['current_password'];
    $nueva_contrasena = $_POST['new_password'];
    $confirmar_contrasena = $_POST['confirm_password'];

    $stmt = $db->prepare("SELECT email_correo, celular, direccion, contraseña FROM persona WHERE id_persona = ?");
    $stmt->execute([$id_persona]);
    $usuario_actual = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario_actual) {
        mostrarMensaje('error', 'Error', 'No se encontraron datos para el ID proporcionado.');
        return;
    }

    $campos = [];
    $valores = [];

    if ($correo !== $usuario_actual['email_correo']) {
        $campos[] = 'email_correo = ?';
        $valores[] = $correo;
    }
    if ($celular !== $usuario_actual['celular']) {
        $campos[] = 'celular = ?';
        $valores[] = $celular;
    }
    if ($direccion !== $usuario_actual['direccion']) {
        $campos[] = 'direccion = ?';
        $valores[] = $direccion;
    }
    if (!empty($nueva_contrasena)) {
        if (!verificarContrasenaActual($db, $id_persona, $contrasena_actual)) {
            mostrarMensaje('error', 'Error', 'La contraseña actual es incorrecta.');
            return;
        }

        if (strlen($nueva_contrasena) < 6) {
            mostrarMensaje('warning', 'Advertencia', 'La nueva contraseña debe tener al menos 6 caracteres.');
            return;
        }

        if ($nueva_contrasena !== $confirmar_contrasena) {
            mostrarMensaje('error', 'Error', 'Las contraseñas nuevas no coinciden.');
            return;
        }

        $campos[] = 'contraseña = ?';
        $valores[] = $nueva_contrasena;
    }
    if (!empty($campos)) {
        $valores[] = $id_persona;
        $sql = "UPDATE persona SET " . implode(', ', $campos) . " WHERE id_persona = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($valores);
        mostrarMensaje('success', 'Éxito', 'Datos actualizados correctamente.');
    } else {
        mostrarMensaje('info', 'Info', 'No se realizaron cambios.');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    procesarFormulario($db, $id_persona);
}

$stmt = $db->prepare("SELECT * FROM persona WHERE id_persona = ?");
$stmt->execute([$id_persona]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die('Error: No se encontraron datos para el ID proporcionado.');
}
?>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>Configuración de Usuario</h3>
            </div>
            <div class="card-body">
                <form method="post" action="">
                    <div class="accordion" id="accordionExample">
                        <!-- Datos Personales -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingPersonal">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePersonal" aria-expanded="true" aria-controls="collapsePersonal">
                                    Datos Personales
                                </button>
                            </h2>
                            <div id="collapsePersonal" class="accordion-collapse collapse show" aria-labelledby="headingPersonal" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" value="<?= htmlspecialchars($usuario['nombre']); ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellido" class="form-label">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" value="<?= htmlspecialchars($usuario['apellido']); ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="dni" class="form-label">DNI</label>
                                        <input type="text" class="form-control" id="dni" value="<?= htmlspecialchars($usuario['DNI']); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Datos de Contacto -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingContacto">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContacto" aria-expanded="false" aria-controls="collapseContacto">
                                    Datos de Contacto
                                </button>
                            </h2>
                            <div id="collapseContacto" class="accordion-collapse collapse" aria-labelledby="headingContacto" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="correo" class="form-label">Correo</label>
                                        <input type="email" class="form-control" id="correo" name="correo" value="<?= htmlspecialchars($usuario['email_correo']); ?>" required autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="celular" class="form-label">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" value="<?= htmlspecialchars($usuario['celular']); ?>" required autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Ciudad" class="form-label">Ciudad</label>
                                        <input type="text" class="form-control" id="Ciudad" name="Ciudad" value="<?= htmlspecialchars($usuario['ciudad']); ?>" required autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($usuario['direccion']); ?>" required autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Datos de Cuenta -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingCuenta">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCuenta" aria-expanded="false" aria-controls="collapseCuenta">
                                    Datos de Cuenta
                                </button>
                            </h2>
                            <div id="collapseCuenta" class="accordion-collapse collapse" aria-labelledby="headingCuenta" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label for="current_password" class="form-label">Contraseña Actual</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password">
                                    </div>
                                    <div class="mb-3 position-relative">
                                        <label for="new_password" class="form-label">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="new_password" name="new_password" oninput="validatePasswordLength()">
                                        <button type="button" class="btn btn-secondary position-absolute top-50 end-0 translate-middle-y" onclick="togglePasswordVisibility('new_password', this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <div id="passwordHelp" class="form-text text-danger" style="display: none;">
                                            La contraseña debe tener al menos 6 caracteres.
                                        </div>
                                    </div>
                                    <div class="mb-3 position-relative">
                                        <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                        <button type="button" class="btn btn-secondary position-absolute top-50 end-0 translate-middle-y" onclick="togglePasswordVisibility('confirm_password', this)">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 text-center">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap and SweetAlert scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePasswordVisibility(id, button) {
            const input = document.getElementById(id);
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            button.innerHTML = type === 'password' ? '<i class="bi bi-eye"></i>' : '<i class="bi bi-eye-slash"></i>';
        }

        function validatePasswordLength() {
            const password = document.getElementById('new_password').value;
            const message = document.getElementById('passwordHelp');
            message.style.display = password.length < 6 ? 'block' : 'none';
        }
    </script>
</body>
</html>
