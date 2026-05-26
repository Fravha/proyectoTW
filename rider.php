<?php
session_start();
if(!isset($_SESSION['user_id']) || !isset($_SESSION['puesto']) || $_SESSION['puesto'] != 'Motorizado') {
    header("Location: index.php");
    exit;
}
require_once 'config.php';
$rider_id = $_SESSION['user_id'];

// Manejar actualización de estado
if(isset($_POST['update_status']) && isset($_POST['idDelivery'])) {
    $idDel = intval($_POST['idDelivery']);
    $nuevoEstado = $conn->real_escape_string($_POST['update_status']);
    $conn->query("UPDATE delivery SET estadoEntrega = '$nuevoEstado' WHERE idDelivery = $idDel AND idMotorizado = $rider_id");
}

// Obtener entregas asignadas al rider
$sql = "SELECT d.idDelivery, c.nombre, c.noTelefono, d.direccionEscrita, d.estadoEntrega, d.ubicacionGPS
        FROM delivery d 
        JOIN venta v ON d.idVenta = v.idVenta 
        JOIN cliente c ON v.idCliente = c.idCliente
        WHERE d.idMotorizado = $rider_id AND d.estado = 'Activo'";
$result = $conn->query($sql);
$entregas = [];
while($row = $result->fetch_assoc()) {
    $entregas[] = $row;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Motorizado</title>
    <link rel="stylesheet" href="style.css">
    <!-- Leaflet CSS for Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
</head>
<body>
    <div class="app-wrapper">
        <nav class="navbar">
            <h2>Tienda Delivery <span>| Motorizado</span></h2>
            <div class="nav-user">
                <span>🏍️ Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
                <a href="logout.php" class="btn" style="padding: 0.5rem 1.5rem; width: auto; background: rgba(239, 68, 68, 0.2); color: var(--danger); border: 1px solid rgba(239, 68, 68, 0.5);">Cerrar Sesión</a>
            </div>
        </nav>

        <div class="dashboard-container">
            <h3 style="font-size: 1.8rem; margin-bottom: 2rem;">Mis Entregas Asignadas</h3>
            
            <div class="cards-grid">
                <?php foreach($entregas as $entrega): ?>
                <div class="glass-card delivery-card">
                    <div>
                        <div class="delivery-header">
                            <h3>A: <?php echo htmlspecialchars($entrega['nombre']); ?></h3>
                            <span class="badge <?php echo str_replace(' ', '-', $entrega['estadoEntrega']); ?>">
                                <?php echo $entrega['estadoEntrega']; ?>
                            </span>
                        </div>
                        
                        <div class="delivery-info">
                            <p>📞 <span><?php echo htmlspecialchars($entrega['noTelefono']); ?></span></p>
                            <p>📍 <span><?php echo htmlspecialchars($entrega['direccionEscrita']); ?></span></p>
                        </div>

                        <?php if($entrega['ubicacionGPS']): ?>
                            <div id="map-<?php echo $entrega['idDelivery']; ?>" style="height: 200px; width: 100%; border-radius: 0.5rem; margin-bottom: 1.5rem; z-index: 1;"></div>
                            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    var coords = [<?php echo $entrega['ubicacionGPS']; ?>];
                                    var map = L.map('map-<?php echo $entrega['idDelivery']; ?>').setView(coords, 15);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '© OpenStreetMap'
                                    }).addTo(map);
                                    
                                    var marker = L.marker(coords).addTo(map);
                                    marker.bindPopup("<b>Destino</b><br><?php echo addslashes($entrega['direccionEscrita']); ?>").openPopup();
                                    
                                    // Forzar renderizado despues de que la card se cargue
                                    setTimeout(function(){ map.invalidateSize(); }, 500);
                                });
                            </script>
                        <?php endif; ?>
                    </div>

                    <?php if($entrega['estadoEntrega'] != 'Entregado'): ?>
                    <form method="POST" class="delivery-actions">
                        <input type="hidden" name="idDelivery" value="<?php echo $entrega['idDelivery']; ?>">
                        
                        <?php if($entrega['estadoEntrega'] == 'Pendiente'): ?>
                            <button type="submit" name="update_status" value="En Camino" class="btn" style="background: var(--accent);">
                                🛵 Iniciar Ruta
                            </button>
                        <?php endif; ?>
                        
                        <?php if($entrega['estadoEntrega'] == 'En Camino'): ?>
                            <button type="submit" name="update_status" value="Entregado" class="btn" style="background: var(--success);">
                                ✅ Entregado
                            </button>
                        <?php endif; ?>
                    </form>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            
            <?php if(count($entregas) == 0): ?>
                <div class="glass-card" style="text-align: center; padding: 4rem;">
                    <h3 style="color: var(--text-muted); font-weight: 400;">No tienes entregas asignadas en este momento.</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">Toma un descanso o contacta al administrador.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
