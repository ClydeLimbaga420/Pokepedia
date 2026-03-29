<?php
include 'config.php';

$typeStmt = $pdo->query("SELECT type, COUNT(*) as count FROM (SELECT type1 as type FROM pokemon UNION ALL SELECT type2 as type FROM pokemon WHERE type2 IS NOT NULL AND type2 != '') as combined_types GROUP BY type ORDER BY count DESC");
$typeDistribution = $typeStmt->fetchAll(PDO::FETCH_ASSOC);

$typeLabels = [];
$typeCounts = [];
foreach ($typeDistribution as $row) {
    $typeLabels[] = ucfirst($row['type']);
    $typeCounts[] = $row['count'];
}

$typeColors = [
    'Fire' => '#ff421c', 
    'Water' => '#2980ef', 
    'Grass' => '#62bc5a',
    'Electric' => '#f1c40f', 
    'Psychic' => '#9b59b6', 
    'Ice' => '#5dade2',
    'Dragon' => '#503da3', 
    'Dark' => '#2c3e50', 
    'Fairy' => '#e91e63',
    'Normal' => '#95a5a6', 
    'Fighting' => '#c0392b', 
    'Poison' => '#8e44ad',
    'Ground' => '#d35400', 
    'Rock' => '#7b8d93', 
    'Bug' => '#27ae60',
    'Ghost' => '#4b5a94', 
    'Steel' => '#bdc3c7', 
    'Flying' => '#7f8c8d',
];

$backgroundColors = [];
foreach ($typeLabels as $label) {
    $backgroundColors[] = $typeColors[$label] ?? '#333';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Type Analytics | Poképedia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: radial-gradient(circle at center, #1a1a1a 0%, #050505 100%);
            color: white;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .chart-container {
            width: 100%;
            max-width: 650px;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 50px 30px;
            border-radius: 50px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.6);
            position: relative;
        }

        h2 {
            text-align: center;
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: 4px;
            margin-bottom: 5px;
            text-transform: uppercase;
            background: linear-gradient(to right, #fff, #666);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.subtitle {
            text-align: center;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 40px;
            letter-spacing: 1px;
        }

        .back-btn {
            margin-top: 40px;
            text-decoration: none;
            color: white;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 1px;
            padding: 12px 25px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .back-btn:hover {
            background: white;
            color: black;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .chart-container::after {
            content: '';
            position: absolute;
            top: 50%; left: 50%;
            width: 80%; height: 80%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            transform: translate(-50%, -50%);
            z-index: -1;
        }
    </style>
</head>
<body>
    
    <div class="chart-container">
        <h2>Type Chart</h2>
        <p class="subtitle">Total Types</p>
        <canvas id="pokemonTypeChart"></canvas>
    </div>

    <a href="index.php" class="back-btn">← RETURN TO POKÉPEDIA</a>

    <script>
    const ctx = document.getElementById('pokemonTypeChart').getContext('2d');
    
    const centerTextPlugin = {
        id: 'centerText',
        afterDraw: (chart) => {
            const { ctx, chartArea: { top, bottom, left, right, width, height } } = chart;
            ctx.save();
            const total = chart.config.data.datasets[0].data.reduce((a, b) => a + b, 0);
            
            ctx.font = 'bold 2.5rem Poppins';
            ctx.fillStyle = 'white';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText(total, left + width / 2, top + height / 2 - 10);
            
            ctx.font = '400 0.75rem Poppins';
            ctx.fillStyle = 'rgba(255,255,255,0.4)';
            ctx.fillText('TOTAL ENTRIES', left + width / 2, top + height / 2 + 25);
            ctx.restore();
        }
    };

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($typeLabels); ?>,
            datasets: [{
                data: <?php echo json_encode($typeCounts); ?>,
                backgroundColor: <?php echo json_encode($backgroundColors); ?>,
                
                borderWidth: 2,                 
                borderColor: 'rgba(255, 255, 255, 0.2)', 
                hoverBorderColor: '#ffffff',    
                hoverBorderWidth: 3,           
                hoverOffset: 30,
                borderRadius: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: 'rgba(255, 255, 255, 0.5)',
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: { family: 'Poppins', size: 11 },
                        padding: 25
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0,0,0,0.8)',
                    padding: 15,
                    titleFont: { size: 14, weight: 'bold', family: 'Poppins' },
                    bodyFont: { size: 13, family: 'Poppins' },
                    displayColors: true,
                    boxPadding: 6,
                    callbacks: {
                        label: function(item) {
                            let sum = item.dataset.data.reduce((a, b) => a + b, 0);
                            let value = item.raw;
                            let percentage = ((value / sum) * 100).toFixed(1);
                            return ` ${item.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '78%',
        },
        plugins: [centerTextPlugin]
    });
</script>
</body>
</html>