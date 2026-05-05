let modalMenu, modalRes;

document.addEventListener("DOMContentLoaded", function() {
    modalMenu = new bootstrap.Modal(document.getElementById('modalMenuConsultas'));
    modalRes = new bootstrap.Modal(document.getElementById('modalResultados'));
});

function procesarConsulta(id) {
    modalMenu.hide();
    
    document.getElementById('contenedorResultados').innerHTML = `
        <div class="text-center py-5">
            <div class="spinner-border text-green" style="width: 3rem; height: 3rem;" role="status"></div>
            <h5 class="mt-3 text-muted">Procesando consulta SQL...</h5>
        </div>
    `;
    
    modalRes.show();

    // Pide la info a conexion.php
    fetch('conexion.php?ajax_consulta=' + id)
        .then(response => response.text())
        .then(html => {
            document.getElementById('contenedorResultados').innerHTML = html;
        })
        .catch(error => {
            document.getElementById('contenedorResultados').innerHTML = '<div class="alert alert-danger">Error de comunicación con la base de datos.</div>';
        });
}

function volverAlMenu() {
    modalRes.hide();
    setTimeout(() => { modalMenu.show(); }, 300);
}

// Inicialización de Gráficos
Chart.register(ChartDataLabels);

const ctxDonut = document.getElementById('donutChart').getContext('2d');
new Chart(ctxDonut, {
    type: 'doughnut',
    data: {
        labels: ['Tensión', 'Corriente', 'Potencia'],
        datasets: [{
            data: [40, 35, 25],
            backgroundColor: ['#20ff9a', '#d4ff47', '#2e5944'],
            borderWidth: 0,
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
            legend: { position: 'bottom', labels: { color: '#a3c9b3', padding: 20, font: { size: 12, weight: 'bold' } } },
            datalabels: {
                color: '#ffffff',
                font: { weight: '900', size: 13 },
                formatter: (val) => val + '%'
            }
        }
    }
});

const ctxLine = document.getElementById('lineChart').getContext('2d');
new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
        datasets: [{
            label: 'Tensión (V)',
            data: [220, 218, 222, 225, 221, 219],
            borderColor: '#d4ff47',
            backgroundColor: 'rgba(212, 255, 71, 0.08)',
            borderWidth: 3,
            pointBackgroundColor: '#20ff9a',
            pointBorderColor: '#ffffff',
            pointRadius: 5,
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { grid: { color: 'rgba(32, 255, 154, 0.1)' }, ticks: { color: '#a3c9b3', font: {weight: 'bold'} } },
            x: { grid: { display: false }, ticks: { color: '#a3c9b3', font: {weight: 'bold'} } }
        },
        plugins: { legend: { display: false }, datalabels: { display: false } }
    }
});

// Inicialización de Mapa
const map = L.map('map').setView([-34.6037, -58.3816], 5);
L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
    attribution: '&copy; CARTO',
    subdomains: 'abcd'
}).addTo(map);

// La variable estacionesData se inyectará desde el index.php
if (typeof estacionesData !== 'undefined') {
    estacionesData.forEach(est => {
        L.circleMarker([parseFloat(est.latitud), parseFloat(est.longitud)], {
            color: '#d4ff47', fillColor: '#20ff9a', fillOpacity: 0.9, radius: 7, weight: 2
        }).addTo(map).bindPopup(`<b style="color:#12221a">${est.nombre}</b><br><span style="color:#1c3628">${est.localidad}</span>`);
    });
}