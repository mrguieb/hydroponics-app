<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hydroponic Sensor Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Chart.js Date Adapter -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
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
            background: #4F46E5;
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
        .chart-container {
            margin-top: 40px;
            text-align: center;
        }
        @media (max-width: 640px) {
            .cards {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title-box">
            <h1>🌱 Hydroponic Sensor Dashboard</h1>
            <p>Real-time data from your IoT sensors</p>
        </div>

        @if($data->isNotEmpty())
        <div class="cards">
            <div class="card">
                <h2>{{ $data[0]->temperature }}°C</h2>
                <p>Temperature</p>
            </div>
            <div class="card">
                <h2>{{ $data[0]->humidity }}%</h2>
                <p>Humidity</p>
            </div>
            <div class="card">
                <h2>{{ $data[0]->ldr_analog }}</h2>
                <p>LDR Analog</p>
            </div>
            <div class="card">
                <h2>{{ $data[0]->ldr_digital ? 'Bright' : 'Dark' }}</h2>
                <p>LDR Digital</p>
            </div>
            <div class="card">
                <h2>{{ $data[0]->distance }} cm</h2>
                <p>Water Level</p>
            </div>
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Temperature</th>
                    <th>Humidity</th>
                    <th>LDR Analog</th>
                    <th>LDR Digital</th>
                    <th>Distance</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $item->temperature }}°C</td>
                    <td>{{ $item->humidity }}%</td>
                    <td>{{ $item->ldr_analog }}</td>
                    <td>{{ $item->ldr_digital ? 'Bright' : 'Dark' }}</td>
                    <td>{{ $item->distance }} cm</td>
                    <td>{{ $item->created_at->format('M d, Y H:i:s') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Chart Container -->
        <div class="chart-container">
            <canvas id="sensorChart" width="400" height="200"></canvas>
        </div>
    </div>

<script>
    // Initialize Chart.js chart
    const ctx = document.getElementById('sensorChart').getContext('2d');
    let sensorChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [], // Time or timestamp will go here
            datasets: [{
                label: 'Temperature (°C)',
                data: [], // Temperature data will be pushed here
                borderColor: 'rgba(75, 192, 192, 1)',
                fill: false
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'time', // Change to time scale for better handling of timestamps
                    time: {
                        unit: 'minute', // Display time in minutes
                        tooltipFormat: 'll HH:mm'
                    },
                    title: {
                        display: true,
                        text: 'Time'
                    }
                },
                y: {
                    beginAtZero: false,
                    title: {
                        display: true,
                        text: 'Temperature (°C)'
                    }
                }
            }
        }
    });

    // Function to fetch data and update the chart
    function fetchData() {
        fetch('/get-sensor-data') // Replace with the URL that returns your sensor data
            .then(response => response.json())
            .then(data => {
                // Update chart labels and data
                if (data.length) {
                    const latestData = data[data.length - 1];
                    const timestamp = new Date(latestData.created_at).getTime(); // Convert to Unix timestamp (ms)
                    sensorChart.data.labels.push(timestamp);
                    sensorChart.data.datasets[0].data.push(latestData.temperature);
                }

                // Remove old data points to keep chart clean
                if (sensorChart.data.labels.length > 20) { // Keep last 20 data points
                    sensorChart.data.labels.shift();
                    sensorChart.data.datasets[0].data.shift();
                }

                // Update the chart
                sensorChart.update();
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Fetch initial data
    fetchData();

    // Set interval to fetch new data every 10 seconds
    setInterval(fetchData, 10000);
</script>

</body>
</html>
