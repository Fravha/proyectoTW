<?php
session_start();
if(!isset($_SESSION['user_id']) || !isset($_SESSION['puesto']) || $_SESSION['puesto'] == 'Motorizado') {
    header("Location: index.php");
    exit;
}
require_once 'config.php';

// Obtener todas las ventas activas de delivery
$sql = "SELECT d.idDelivery, v.idVenta, c.nombre as cliente, c.noTelefono, d.direccionEscrita, d.estadoEntrega, t.nombre as rider 
        FROM delivery d 
        JOIN venta v ON d.idVenta = v.idVenta 
        JOIN cliente c ON v.idCliente = c.idCliente
        LEFT JOIN trabajador t ON d.idMotorizado = t.idTrabajador
        WHERE d.estado = 'Activo'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="app-wrapper">
        <nav class="navbar">
            <h2>Tienda Delivery <span>| Admin</span></h2>
            <div class="nav-user">
                <span>👤 Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                <a href="logout.php" class="btn" style="padding: 0.5rem 1.5rem; width: auto; background: rgba(239, 68, 68, 0.2); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.5);">Cerrar Sesión</a>
            </div>
        </nav>
        
        <div class="dashboard-container">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h3 style="font-size: 1.8rem; margin: 0;">Entregas Activas</h3>
                <span class="badge" style="background: var(--primary); color: white;">Total: <?php echo $result->num_rows; ?></span>
            </div>

            <div class="glass-card" style="padding: 0;">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th># Orden</th>
                                <th>Cliente</th>
                                <th>Teléfono</th>
                                <th>Dirección de Entrega</th>
                                <th>Motorizado Asignado</th>
                                <th>Estado Actual</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td style="font-weight: 600;">#<?php echo str_pad($row['idVenta'], 4, '0', STR_PAD_LEFT); ?></td>
                                    <td><?php echo htmlspecialchars($row['cliente']); ?></td>
                                    <td><?php echo htmlspecialchars($row['noTelefono']); ?></td>
                                    <td><?php echo htmlspecialchars($row['direccionEscrita']); ?></td>
                                    <td>
                                        <?php if($row['rider']): ?>
                                            🏍️ <?php echo htmlspecialchars($row['rider']); ?>
                                        <?php else: ?>
                                            <span style="color: var(--text-muted); font-style: italic;">No asignado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo str_replace(' ', '-', $row['estadoEntrega']); ?>">
                                            <?php echo $row['estadoEntrega']; ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 3rem; color: var(--text-muted);">
                                        No hay entregas activas en este momento.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
