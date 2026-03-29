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
    <title>Type Chart</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    
    <div class="chart-container">
        <h2>TYPE CHART</h2>
        <canvas id="pokemonTypeChart"></canvas>
    </div>

    <a href="index.php" class="back-btn">← BACK TO GALLERY</a>


    <script>
        const ctx = document.getElementById('pokemonTypeChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($typeLabels); ?>,
                datasets: [{
                    data: <?php echo json_encode($typeCounts); ?>,
                    backgroundColor: <?php echo json_encode($backgroundColors); ?>,
                    borderWidth: 2,
                    borderColor: '#0f0f0f',
                    hoverOffset: 20
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: 'rgba(255, 255, 255, 0.7)',
                            font: {
                                family: 'Poppins',
                                size: 10
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(item) {
                                let sum = item.dataset.data.reduce((a, b) => a + b, 0);
                                let value = item.raw;
                                let percentage = ((value / sum) * 100).toFixed(1);
                                return `${item.label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '65%'
            }

        });
    </script>
</body>
</html>