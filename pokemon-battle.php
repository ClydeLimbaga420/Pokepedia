<?php
include 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;
$stmt = $pdo->prepare("SELECT * FROM pokemon WHERE pokemon_id = ?");
$stmt->execute([$id]);
$pokemon = $stmt->fetch(PDO::FETCH_ASSOC);

$types = [strtolower($pokemon['type1'])];
if (!empty($pokemon['type2'])) {
    $types[] = strtolower($pokemon['type2']);
}

$chart = [
    'normal'   => ['rock'=>0.5, 'ghost'=>0, 'steel'=>0.5],
    'fire'     => ['fire'=>0.5, 'water'=>0.5, 'grass'=>2, 'ice'=>2, 'bug'=>2, 'rock'=>0.5, 'dragon'=>0.5, 'steel'=>2],
    'water'    => ['fire'=>2, 'water'=>0.5, 'grass'=>0.5, 'ground'=>2, 'rock'=>2, 'dragon'=>0.5],
    'grass'    => ['fire'=>0.5, 'water'=>2, 'grass'=>0.5, 'poison'=>0.5, 'ground'=>2, 'flying'=>0.5, 'bug'=>0.5, 'rock'=>2, 'dragon'=>0.5, 'steel'=>0.5],
    'electric' => ['water'=>2, 'grass'=>0.5, 'electric'=>0.5, 'ground'=>0, 'flying'=>2, 'dragon'=>0.5],
    'ice'      => ['fire'=>0.5, 'water'=>0.5, 'grass'=>2, 'ice'=>0.5, 'ground'=>2, 'flying'=>2, 'dragon'=>2, 'steel'=>0.5],
    'fighting' => ['normal'=>2, 'ice'=>2, 'poison'=>0.5, 'flying'=>0.5, 'psychic'=>0.5, 'bug'=>0.5, 'rock'=>2, 'ghost'=>0, 'dark'=>2, 'steel'=>2, 'fairy'=>0.5],
    'poison'   => ['grass'=>2, 'poison'=>0.5, 'ground'=>0.5, 'rock'=>0.5, 'ghost'=>0.5, 'steel'=>0, 'fairy'=>2],
    'ground'   => ['fire'=>2, 'grass'=>0.5, 'electric'=>2, 'poison'=>2, 'flying'=>0, 'bug'=>0.5, 'rock'=>2, 'steel'=>2],
    'flying'   => ['grass'=>2, 'electric'=>0.5, 'fighting'=>2, 'bug'=>2, 'rock'=>0.5, 'steel'=>0.5],
    'psychic'  => ['fighting'=>2, 'poison'=>2, 'psychic'=>0.5, 'dark'=>0, 'steel'=>0.5],
    'bug'      => ['fire'=>0.5, 'grass'=>2, 'fighting'=>0.5, 'poison'=>0.5, 'flying'=>0.5, 'psychic'=>2, 'ghost'=>0.5, 'dark'=>2, 'steel'=>0.5, 'fairy'=>0.5],
    'rock'     => ['fire'=>2, 'ice'=>2, 'fighting'=>0.5, 'ground'=>0.5, 'flying'=>2, 'bug'=>2, 'steel'=>0.5],
    'ghost'    => ['normal'=>0, 'psychic'=>2, 'ghost'=>2, 'dark'=>0.5],
    'dragon'   => ['dragon'=>2, 'steel'=>0.5, 'fairy'=>0],
    'dark'     => ['fighting'=>0.5, 'psychic'=>2, 'ghost'=>2, 'dark'=>0.5, 'fairy'=>0.5],
    'steel'    => ['fire'=>0.5, 'water'=>0.5, 'electric'=>0.5, 'ice'=>2, 'rock'=>2, 'steel'=>0.5, 'fairy'=>2],
    'fairy'    => ['fire'=>0.5, 'fighting'=>2, 'poison'=>0.5, 'dragon'=>2, 'dark'=>2, 'steel'=>0.5]
];

$allTypes = array_keys($chart);
$results = [];

foreach ($allTypes as $attacker) {
    $multiplier = 1.0;
    foreach ($types as $defender) {
        if (isset($chart[$attacker][$defender])) {
            $multiplier *= $chart[$attacker][$defender];
        }
    }

    if( $multiplier != 1.0 ) {
        $results[$attacker] = $multiplier;
    }
}

asort($results);
    $weak = array_filter($results, fn($m) => $m > 1);
    $resist = array_filter($results, fn($m) => $m < 1 && $m > 0);
    $immune = array_filter($results, fn($m) => $m == 0);




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Types</title>

    <style>
        
        :root {
            --bg-dark: #050505;
            --card-bg: rgba(255, 255, 255, 0.03);
            --danger: #ff421c;
            --safe: #82bc5a;
            --immune: #2980ef;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            background-image: linear-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0..05) 1px, transparent 1px);
            background-size: 50px 50px;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
    
    </style>

</head>
<body>
    <div class="battle-grid">
        <?php if(!empty($immune)): ?>
            <div class="analysis-card immunity">
                <h4>TOTAL IMMUNITY</h4>
                <div class="type-list">
                    <?php foreach($immune as $type => $m): ?>
                        <span class="type-pill <?= $type ?>"><?= $type ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="analysis-card danger">
            <h4>VULNERABLE TO</h4>
            <div class="type-list">
                <?php foreach($weak as $type => $m): ?>
                    <div class="type-pill <?= $type ?>">
                        <?= $type ?> <span class="mult"><?= $m ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="analysis-card safe">
            <h4>RESISTANT TO</h4>
            <div class="type-list">
                <?php foreach($resist as $type => $m): ?>
                    <div class="type-pill <?= $type ?>">
                        <?= $type ?> <span class="mult"><?= $m ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>