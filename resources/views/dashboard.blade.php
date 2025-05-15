<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hydroponic Sensor Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: #f9fafa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            padding: 20px;
        }
        .title-box {
            background:rgb(49, 167, 98);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 30px;
        }
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: white;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            text-align: center;
        }
        .card h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        .card p {
            font-size: 1rem;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.04);
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        th {
            background: #f4f6f8;
            font-weight: 600;
        }
        tr:hover {
            background: #f9f9f9;
        }
        @media (max-width: 640px) {
            .cards {
                grid-template-columns: 1fr 1fr;
            }
        }
        .table-responsive {
        width: 100%;
         overflow-x: auto;
        }

        /* Highlight Classes */
        .highlight-hot {
            color: #b91c1c; /* red */
            font-weight: bold;
        }
        .highlight-humid {
            color: #2563eb; /* blue */
            font-weight: bold;
        }
        .highlight-bright {
            color: #facc15; /* yellow */
            font-weight: bold;
        }
        .highlight-water-low {
            color:rgb(15, 163, 1); /* green */
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title-box">
            <h1>Hydroponic Petchay Sensor Dashboard</h1>
            <p>Real-time data sensors</p>
        </div>

        <!-- AJAX data content -->
        <div id="sensor-data-container">
            @include('partials.sensor-data')
        </div>
    </div>

<script>
    // Auto-refresh sensor data every 10 seconds using AJAX
    function refreshSensorData() {
        fetch('/sensor-latest')
            .then(response => response.text())
            .then(html => {
                document.getElementById('sensor-data-container').innerHTML = html;
            })
            .catch(error => {
                console.error('Failed to fetch latest sensor data:', error);
            });
    }

    setInterval(refreshSensorData, 5000); // every 10 seconds
</script>

</body>
</html>
