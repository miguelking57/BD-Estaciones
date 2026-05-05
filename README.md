# 🍃 AHK Eco-Monitor - Sustentabilidad y Energía

**Trabajo Práctico Integrador - Computación II**
*C.F.I. Hölters*

![Estado](https://img.shields.io/badge/Estado-Completado-brightgreen)
![Tecnologías](https://img.shields.io/badge/Tecnologías-PHP%20%7C%20MySQL%20%7C%20JS%20%7C%20Bootstrap-blue)

AHK Eco-Monitor es un panel de control interactivo (Dashboard) diseñado para monitorear en tiempo real la infraestructura eléctrica de una red de estaciones y subestaciones distribuidas a nivel nacional. Permite visualizar el estado de sensores de Tensión, Corriente y Potencia, analizar curvas de carga y ubicar geográficamente cada nodo de la red.

# Características Principales

*   **Dashboard Interactivo:** KPIs en tiempo real con datos de picos de potencia, tensión mínima y flujo de datos.
*   **Visualización de Datos:** Gráficos de anillo (recursos monitoreados) y líneas (curva de carga) generados dinámicamente con Chart.js.
*   **Mapa Geográfico:** Integración con Leaflet para mostrar la ubicación exacta de cada estación a través de sus coordenadas.
*   **Consultas SQL Dinámicas:** Sistema AJAX integrado para ejecutar las 7 consultas solicitadas en el TP directamente desde la interfaz web, sin recargar la página.
*   **Diseño Separado:** Arquitectura limpia separando lógica (PHP), diseño (CSS) e interactividad (JS).

#  Tecnologías Utilizadas

*   **Backend:** PHP 8+
*   **Base de Datos:** MySQL / MariaDB (HeidiSQL para administración)
*   **Frontend:** HTML5, CSS3, JavaScript (ES6)
*   **Framework CSS:** Bootstrap 5.3
*   **Librerías Adicionales:** 
    *   [Chart.js](https://www.chartjs.org/) (Gráficos estadísticos)
    *   [Leaflet.js](https://leafletjs.com/) (Mapas interactivos)

## 📁 Estructura del Proyecto
```text
/
├── index.php                 # Interfaz principal (Dashboard)
├── conexion.php              # Lógica de conexión a BD y manejo de consultas AJAX
├── Base_de_Datos_Completa.sql# Dump de la base de datos (Estructura y Registros)
├── DER_Modelo_Datos.png      # Diagrama de Entidad-Relación (DER)
├── consultas.sql             # Archivo con las 7 consultas SQL solicitadas
├── README.md                 # Este archivo
├── /css
│   └── estilos.css           # Hoja de estilos principal
└── /js
    └── app.js                # Lógica de UI, inicialización de gráficos, mapas y AJAX
