<?php require_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AHK Eco-Monitor - Base de Datos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<div class="container-fluid px-5">
    <header class="top-bar">
        <div>
            <div class="logo-text"><i class="bi bi-leaf-fill text-green"></i> <span class="text-green">AHK</span> ECO-MONITOR</div>
            <div class="text-white mt-1" style="font-size: 0.95rem; font-weight: 500;">Sustentabilidad y Energía - C.F.I. Hölters</div>
        </div>
        <div>
            <span class="me-4 text-white fw-bold fs-5"><i class="bi bi-calendar-event text-lime"></i> <?php echo date('d/m/Y'); ?></span>
            <button class="btn btn-cargar rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalMenuConsultas">
                <i class="bi bi-search me-1"></i> EJECUTAR CONSULTAS
            </button>
        </div>
    </header>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="dashboard-card border-neon-green text-center">
                <div class="kpi-title">PICO DE POTENCIA (Hoy)</div>
                <div class="kpi-value text-white"><?php echo $maxDia; ?> <span class="fs-4 text-green">W</span></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card border-neon-lime text-center">
                <div class="kpi-title">TENSIÓN MÍNIMA (Hoy)</div>
                <div class="kpi-value text-white"><?php echo $minDia; ?> <span class="fs-4 text-lime">V</span></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card text-center">
                <div class="kpi-title">FLUJO DE DATOS</div>
                <div class="kpi-value text-white"><i class="bi bi-reception-4 text-green"></i> <?php echo $actividad; ?></div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="dashboard-card">
                <div class="kpi-title mb-4">RECURSOS MONITOREADOS</div>
                <div class="chart-container">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="dashboard-card">
                <div class="kpi-title mb-3"><i class="bi bi-geo-alt-fill text-lime"></i> RED GEOGRÁFICA NACIONAL</div>
                <div id="map"></div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="dashboard-card">
                <div class="kpi-title mb-3"><i class="bi bi-list-check text-green"></i> ÚLTIMOS REGISTROS</div>
                <div class="table-responsive">
                    <table class="table table-dark-custom">
                        <thead>
                            <tr>
                                <th>ESTACIÓN</th>
                                <th>SENSOR</th>
                                <th>VALOR</th>
                                <th>ESTADO</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($resTabla && $resTabla->num_rows > 0): ?>
                                <?php while($fila = $resTabla->fetch_assoc()): ?>
                                <tr>
                                    <td><span class="text-white fw-bold"><?php echo htmlspecialchars($fila['estacion']); ?></span></td>
                                    <td><i class="bi bi-lightning-charge text-lime"></i> <span style="color: var(--text-muted);"><?php echo htmlspecialchars($fila['sensor']); ?></span></td>
                                    <td class="text-green fw-bold fs-5"><?php echo htmlspecialchars($fila['valor']); ?></td>
                                    <td><span class="badge badge-eco rounded-pill">ONLINE</span></td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center" style="color: var(--text-muted);">Buscando señales...</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="dashboard-card">
                <div class="kpi-title mb-3"><i class="bi bi-graph-up-arrow text-lime"></i> CURVA DE CARGA DIARIA</div>
                <div class="chart-container">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMenuConsultas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-green"><i class="bi bi-database-fill-gear"></i> GESTOR DE CONSULTAS SQL</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="list-group list-group-flush">
                    <div class="list-group-item list-group-item-eco p-4" onclick="procesarConsulta(1)">
                        <i class="bi bi-sort-alpha-down text-lime me-2 fs-5"></i> <strong>1.</strong> Listado de Sensores ordenados Alfabéticamente
                    </div>
                    <div class="list-group-item list-group-item-eco p-4" onclick="procesarConsulta(2)">
                        <i class="bi bi-123 text-lime me-2 fs-5"></i> <strong>2.</strong> Cantidad de Sensores Por Central
                    </div>
                    <div class="list-group-item list-group-item-eco p-4" onclick="procesarConsulta(3)">
                        <i class="bi bi-geo text-lime me-2 fs-5"></i> <strong>3.</strong> Listado de Sensores para Lat: 34.5400377 Long: -58.5588413
                    </div>
                    <div class="list-group-item list-group-item-eco p-4" onclick="procesarConsulta(4)">
                        <i class="bi bi-alphabet text-lime me-2 fs-5"></i> <strong>4.</strong> Sensores en Estaciones de Localidades que comienzan con "V"
                    </div>
                    <div class="list-group-item list-group-item-eco p-4" onclick="procesarConsulta(5)">
                        <i class="bi bi-lightning text-lime me-2 fs-5"></i> <strong>5.</strong> Promedio Consumo Corriente (Hoy) - Villa Ballester
                    </div>
                    <div class="list-group-item list-group-item-eco p-4" onclick="procesarConsulta(6)">
                        <i class="bi bi-graph-up-arrow text-lime me-2 fs-5"></i> <strong>6.</strong> Valor Máximo Potencia (Hoy) - Villa Ballester
                    </div>
                    <div class="list-group-item list-group-item-eco p-4" onclick="procesarConsulta(7)">
                        <i class="bi bi-graph-down-arrow text-lime me-2 fs-5"></i> <strong>7.</strong> Valor Mínimo Tensión (Abril) - Villa Ballester
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalResultados" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold text-lime"><i class="bi bi-table"></i> RESULTADO DE EJECUCIÓN</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="contenedorResultados">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-light rounded-pill" onclick="volverAlMenu()">Volver a Consultas</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    const estacionesData = <?php echo $jsonEstaciones; ?>;
</script>

<script src="js/app.js"></script>

</body>
</html>