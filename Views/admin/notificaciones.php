<?php
require '../../conn/connection.php';
session_start();
$id_usuario = $_SESSION['id_usuario'];

// Marcar mensajes como leídos
$query_update = "
    UPDATE notificaciones 
    SET leido = 1 
    WHERE id_usuario = ? AND leido = 0"; // Actualiza solo los no leídos

$stmt_update = $db->prepare($query_update);
$stmt_update->bindParam(1, $id_usuario);
$stmt_update->execute();

// Resto de tu código para obtener y mostrar las notificaciones
$query_notificaciones = "
    SELECT mensaje, fecha 
    FROM notificaciones 
    WHERE id_usuario = ?
    ORDER BY fecha DESC";

$stmt = $db->prepare($query_notificaciones);
$stmt->bindParam(1, $id_usuario);
$stmt->execute();

$notificaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<body>
    <h1>Notificaciones</h1>
    <?php if (count($notificaciones) > 0): ?>
        <ul>
            <?php foreach ($notificaciones as $notificacion): ?>
                <li>
                    <strong><?php echo htmlspecialchars($notificacion['fecha']); ?></strong>: 
                    <?php echo htmlspecialchars($notificacion['mensaje']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No tienes notificaciones.</p>
    <?php endif; ?>
</body>
<?php require 'footer.php'; ?>
