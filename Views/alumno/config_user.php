<?php
require 'navbar.php';
include('../../conn/connection.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    $correo = !empty($_POST['correo']) ? $_POST['correo'] : null;
    $celular = !empty($_POST['celular']) ? $_POST['celular'] : null;
    $direccion = !empty($_POST['direccion']) ? $_POST['direccion'] : null;
    $contrasena_actual = !empty($_POST['current_password']) ? $_POST['current_password'] : null;
    $nueva_contrasena = !empty($_POST['new_password']) ? $_POST['new_password'] : null;
    $confirmar_contrasena = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : null;

    $stmt = $db->prepare("SELECT email_correo, celular, direccion, contraseña FROM persona WHERE id_persona = ?");
    $stmt->execute([$id_persona]);
    $usuario_actual = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario_actual) {
        mostrarMensaje('error', 'Error', 'No se encontraron datos para el ID proporcionado.');
        return;
    }

    $campos = [];
    $valores = [];

    // Comparar con los valores actuales y agregar a la actualización si son diferentes
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

    // Procesamiento de la contraseña
    if (!empty($nueva_contrasena)) {
        if (!verificarContrasenaActual($db, $id_persona, $contrasena_actual)) {
            mostrarMensaje('error', 'Error', 'La contraseña actual es incorrecta.');
            return;
        }
        if (strlen($nueva_contrasena) < 4) {
            mostrarMensaje('warning', 'Advertencia', 'La nueva contraseña debe tener al menos 4 caracteres.');
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
        try {
            $stmt->execute($valores);
            mostrarMensaje('success', 'Éxito', 'Datos actualizados correctamente.');
        } catch (PDOException $e) {
            mostrarMensaje('error', 'Error', 'Error al actualizar los datos: ' . $e->getMessage());
        }
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
<!-- ----------------- -->
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
                                        <input type="email" class="form-control" id="correo" name="correo" 
                                            value="<?= htmlspecialchars($usuario['email_correo'] ?? ''); ?>" 
                                            autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="celular" class="form-label">Celular</label>
                                        <input type="text" class="form-control" id="celular" name="celular" 
                                            value="<?= htmlspecialchars($usuario['celular'] ?? ''); ?>" 
                                            autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="Ciudad" class="form-label">Ciudad</label>
                                        <input type="text" class="form-control" id="Ciudad" name="Ciudad" 
                                            value="<?= htmlspecialchars($usuario['ciudad'] ?? ''); ?>" 
                                            autocomplete="off">
                                    </div>
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" 
                                            value="<?= htmlspecialchars($usuario['direccion'] ?? ''); ?>" 
                                            autocomplete="off">
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
                                    <div class="mb-3">
                                        <label for="new_password" class="form-label">Nueva Contraseña</label>
                                        <div class="input-group">
                                            <input 
                                                type="password" class="form-control" id="new_password"  name="new_password" 
                                                oninput="validatePasswordLength()" placeholder="Ingrese su contraseña">
                                            <span class="input-group-text" onclick="togglePasswordVisibility('new_password', this)" style="cursor: pointer;">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                        <div id="passwordHelp" class="form-text text-danger" style="display: none;">
                                            La contraseña debe tener al menos 4 caracteres.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                        <div class="input-group">
                                            <input 
                                                type="password" 
                                                class="form-control" 
                                                id="confirm_password" 
                                                name="confirm_password" 
                                                placeholder="Confirme su contraseña">
                                            <span class="input-group-text" onclick="togglePasswordVisibility('confirm_password', this)" style="cursor: pointer;">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
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
    <script>
        function togglePasswordVisibility(id, button) {
            const input = document.getElementById(id);
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            button.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        }

        function validatePasswordLength() {
            const password = document.getElementById('new_password').value;
            const message = document.getElementById('passwordHelp');
            message.style.display = password.length < 4 ? 'block' : 'none';
        }
    </script>
