<?php
// Configuración de la conexión a la base de datos
$host = "localhost";
$user = "root";
$pass = "";
$db   = "TP_Computacion_II";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// =====================================================================
// LÓGICA AJAX PARA RESOLVER LAS CONSULTAS DEL TP EN TIEMPO REAL
// =====================================================================
if (isset($_GET['ajax_consulta'])) {
    $consulta_id = $_GET['ajax_consulta'];
    $sql = "";
    $titulo = "";

    switch ($consulta_id) {
        case '1':
            $titulo = "1. Listado de Sensores ordenados Alfabéticamente";
            $sql = "SELECT s.tipo as 'Tipo de Sensor', e.nombre as 'Estación Perteneciente' FROM Sensores s JOIN Estaciones e ON s.id_estacion = e.id_estacion ORDER BY s.tipo ASC";
            break;
        case '2':
            $titulo = "2. Cantidad de Sensores Por Central";
            $sql = "SELECT e.nombre as 'Central / Estación', COUNT(s.id_sensor) as 'Cantidad Total de Sensores' FROM Estaciones e LEFT JOIN Sensores s ON e.id_estacion = s.id_estacion GROUP BY e.id_estacion, e.nombre";
            break;
        case '3':
            $titulo = "3. Sensores en la Estación (Lat: 34.5400377, Long: -58.5588413)";
            $sql = "SELECT s.id_sensor as 'ID', s.tipo as 'Tipo de Sensor', e.nombre as 'Estación', e.latitud as 'Lat', e.longitud as 'Long' FROM Sensores s JOIN Estaciones e ON s.id_estacion = e.id_estacion WHERE e.latitud = 34.5400377 AND e.longitud = -58.5588413";
            break;
        case '4':
            $titulo = "4. Sensores en Localidades que comienzan con 'V'";
            $sql = "SELECT s.tipo as 'Tipo de Sensor', e.nombre as 'Estación', e.localidad as 'Localidad' FROM Sensores s JOIN Estaciones e ON s.id_estacion = e.id_estacion WHERE e.localidad LIKE 'V%'";
            break;
        case '5':
            $titulo = "5. Promedio de Consumo Corriente (Hoy) en Villa Ballester";
            $sql = "SELECT ROUND(AVG(l.valor), 2) as 'Promedio Corriente (A)' FROM Lecturas l JOIN Sensores s ON l.id_sensor = s.id_sensor JOIN Estaciones e ON s.id_estacion = e.id_estacion WHERE e.localidad = 'Villa Ballester' AND s.tipo = 'Corriente' AND l.fecha = CURDATE()";
            break;
        case '6':
            $titulo = "6. Valor Máximo de Potencia (Hoy) en Villa Ballester";
            $sql = "SELECT MAX(l.valor) as 'Potencia Máxima Registrada (W)' FROM Lecturas l JOIN Sensores s ON l.id_sensor = s.id_sensor JOIN Estaciones e ON s.id_estacion = e.id_estacion WHERE e.localidad = 'Villa Ballester' AND s.tipo = 'Potencia' AND l.fecha = CURDATE()";
            break;
        case '7':
            $titulo = "7. Valor Mínimo de Tensión (Mes de Abril) en Villa Ballester";
            $sql = "SELECT MIN(l.valor) as 'Tensión Mínima Registrada (V)' FROM Lecturas l JOIN Sensores s ON l.id_sensor = s.id_sensor JOIN Estaciones e ON s.id_estacion = e.id_estacion WHERE e.localidad = 'Villa Ballester' AND s.tipo = 'Tensión' AND MONTH(l.fecha) = 4";
            break;
    }

    if ($sql !== "") {
        $resultado = $conn->query($sql);
        echo "<h5 class='text-lime mb-4 fw-bold'>$titulo</h5>";
        if ($resultado && $resultado->num_rows > 0) {
            echo "<div class='table-responsive'><table class='table table-dark-custom table-hover'>";
            $campos = $resultado->fetch_fields();
            echo "<thead><tr>";
            foreach ($campos as $campo) { echo "<th>" . htmlspecialchars($campo->name) . "</th>"; }
            echo "</tr></thead><tbody>";
            while ($fila = $resultado->fetch_assoc()) {
                echo "<tr>";
                foreach ($fila as $valor) { echo "<td><span class='text-white'>" . ($valor !== null ? htmlspecialchars($valor) : 'N/A') . "</span></td>"; }
                echo "</tr>";
            }
            echo "</tbody></table></div>";
        } else {
            echo "<div class='alert' style='background-color: rgba(32, 255, 154, 0.1); border: 1px solid var(--accent-green); color: var(--text-main);'>No se encontraron resultados para esta consulta en la base de datos.</div>";
        }
    }
    exit;
}

// =====================================================================
// EXTRACCIÓN DE DATOS INICIALES PARA EL DASHBOARD
// =====================================================================
$sqlMax = "SELECT MAX(valor) as max_val FROM Lecturas l JOIN Sensores s ON l.id_sensor = s.id_sensor WHERE s.tipo = 'Potencia' AND l.fecha = CURDATE()";
$resMax = $conn->query($sqlMax);
$rowMax = $resMax->fetch_assoc();
$maxDia = ($rowMax && $rowMax['max_val'] !== null) ? number_format($rowMax['max_val'], 2) : "0.00";

$sqlMin = "SELECT MIN(valor) as min_val FROM Lecturas l JOIN Sensores s ON l.id_sensor = s.id_sensor WHERE s.tipo = 'Tensión' AND l.fecha = CURDATE()";
$resMin = $conn->query($sqlMin);
$rowMin = $resMin->fetch_assoc();
$minDia = ($rowMin && $rowMin['min_val'] !== null) ? number_format($rowMin['min_val'], 2) : "0.00";

$sqlAct = "SELECT COUNT(*) as total FROM Lecturas WHERE fecha = CURDATE()";
$resAct = $conn->query($sqlAct);
$actividad = ($resAct && $resAct->num_rows > 0) ? $resAct->fetch_assoc()['total'] : "0";

$sqlTabla = "SELECT e.nombre as estacion, s.tipo as sensor, l.valor, l.hora 
             FROM Lecturas l 
             JOIN Sensores s ON l.id_sensor = s.id_sensor 
             JOIN Estaciones e ON s.id_estacion = e.id_estacion 
             ORDER BY l.fecha DESC, l.hora DESC LIMIT 5";
$resTabla = $conn->query($sqlTabla);

$sqlMapa = "SELECT nombre, localidad, latitud, longitud FROM Estaciones WHERE latitud IS NOT NULL AND longitud IS NOT NULL";
$resMapa = $conn->query($sqlMapa);
$estacionesMapa = [];
if ($resMapa && $resMapa->num_rows > 0) {
    while($row = $resMapa->fetch_assoc()) {
        $estacionesMapa[] = $row;
    }
}
$jsonEstaciones = json_encode($estacionesMapa);
?>