<?php
include 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$stmt = $pdo->prepare("SELECT * FROM pokemon WHERE pokemon_id = ?");
$stmt->execute([$id]);
$pokemon = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pokemon) {
    header("Location: index.php");
    exit;
}

$primaryType = strtolower($pokemon['type1']);
$imagePath = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/" . $pokemon['pokemon_id'] . ".png";

function getStatPercent($value) {
    return ($value / 255) * 100;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst($pokemon['name']) ?> | Poképedia</title>
    <link rel="stylesheet" href="assets/scss/style.scss">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

</head>
<body>
    
    <div class="container">
        <a href="index.php" class="back-btn"> ← Back to Gallery</a>
        
        <div class="pokemon-container">

            <div class="visual-section">
                <div class="main-circle"></div> <img src="<?= $imagePath ?>" alt="<?= $pokemon['name'] ?>" class="main-artwork">
                <h1 class="pokemon-name"><?= ucfirst($pokemon['name']) ?></h1>
                <div class="type-pills">
                    <span class="type-pill <?= $primaryType ?>"><?= $pokemon['type1'] ?></span>
                    <?php if(!empty($pokemon['type2'])): ?>
                        <span class="pill <?= strtolower($pokemon['type2']) ?>"><?= $pokemon['type2'] ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="info-section">
                <div class="glass-card">
                    <h3>Base Stats</h3>
                    <div class="stats-container">
                        <?php
                        $stats = [
                            'HP' => $pokemon['hp'],
                            'ATK' => $pokemon['attack'],
                            'DEF' => $pokemon['defense'],
                            'SP.ATK' => $pokemon['special_attack'],
                            'SP.DEF' => $pokemon['special_defense'],
                            'SPEED' => $pokemon['speed']
                        ];

                        foreach($stats as $label => $value): ?>
                            <div class="stat-row">
                                <span class="stat-label"><?= $label ?></span>
                                <span class="stat-value"><?= $value ?></span>
                                <div class="stat-bar-bg">
                                    <div class="stat-bar-fill <?= $primaryType ?>" style="width: <?= getStatPercent($value) ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>

                <div class="details=grid">
                    <div class="mini-card">
                        <span>Height</span>
                        <p><?= $pokemon['height'] / 10 ?> m</p>
                    </div>
                    <div class="mini-card"?>
                        <span>Weight</span>
                        <p><?= $pokemon['weight'] / 10 ?> kg</p>

                    </div>
                    <div class="mini-card">
                        <span>Ability</span>
                        <p><?= ucfirst($pokemon['ability1']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>