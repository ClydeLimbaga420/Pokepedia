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

$typeChart = [
    'normal' => [
        'weak' => ['fighting'],
        'resist' => [],
        'immune' => ['ghost']
    ],
    'fire' => [
        'weak' => ['water', 'ground', 'rock'],
        'resist' => ['fire', 'grass', 'ice', 'bug', 'steel', 'fairy'],
        'immune' => []
    ],
    'water' => [
        'weak' => ['electric', 'grass'],
        'resist' => ['fire', 'water', 'ice', 'steel'],
        'immune' => []
    ],
    'electric' => [
        'weak' => ['ground'],
        'resist' => ['electric', 'flying', 'steel'],
        'immune' => []
    ],
    'grass' => [
        'weak' => ['fire', 'ice', 'poison', 'flying', 'bug'],
        'resist' => ['water', 'electric', 'grass', 'ground'],
        'immune' => []
    ],
    'ice' => [
        'weak' => ['fire', 'fighting', 'rock', 'steel'],
        'resist' => ['ice'],
        'immune' => []
    ],
    'fighting' => [
        'weak' => ['flying', 'psychic', 'fairy'],
        'resist' => ['bug', 'rock', 'dark'],
        'immune' => []
    ],
    'poison' => [
        'weak' => ['ground', 'psychic'],
        'resist' => ['grass', 'fighting', 'poison', 'bug', 'fairy'],
        'immune' => []
    ],
    'ground' => [
        'weak' => ['water', 'grass', 'ice'],
        'resist' => ['poison', 'rock'],
        'immune' => ['electric']
    ],
    'flying' => [
        'weak' => ['electric', 'ice', 'rock'],
        'resist' => ['grass', 'fighting', 'bug'],
        'immune' => ['ground']
    ],
    'psychic' => [
        'weak' => ['bug', 'ghost', 'dark'],
        'resist' => ['fighting', 'psychic'],
        'immune' => []
    ],
    'bug' => [
        'weak' => ['fire', 'flying', 'rock'],
        'resist' => ['grass', 'fighting', 'ground'],
        'immune' => []
    ],
    'rock' => [
        'weak' => ['water', 'grass', 'fighting', 'ground', 'steel'],
        'resist' => ['normal', 'fire', 'poison', 'flying'],
        'immune' => []
    ],
    'ghost' => [
        'weak' => ['ghost', 'dark'],
        'resist' => ['poison', 'bug'],
        'immune' => ['normal', 'fighting']
    ],
    'dragon' => [
        'weak' => ['ice', 'dragon', 'fairy'],
        'resist' => ['fire', 'water', 'electric', 'grass'],
        'immune' => []
    ],
    'dark' => [
        'weak' => ['fighting', 'bug', 'fairy'],
        'resist' => ['ghost', 'dark'],
        'immune' => ['psychic']
    ],
    'steel' => [
        'weak' => ['fire', 'fighting', 'ground'],
        'resist' => ['normal', 'grass', 'ice', 'flying', 'psychic', 'bug', 'rock', 'dragon', 'steel', 'fairy'],
        'immune' => ['poison']
    ],
    'fairy' => [
        'weak' => ['poison', 'steel'],
        'resist' => ['fighting', 'bug', 'dark'],
        'immune' => ['dragon']
    ],
];

$primaryType = strtoLower($pokemon['type1']);
$weaknesses = $typeChart[$primaryType]['weak'] ?? [];
$resistances = $typeChart[$primaryType]['resist'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Types</title>
</head>
<body>
    <div class="container">
        <h1 style="text-align:center; letter-spacing: 5px;">BATTLE ANALYSIS: <?= strtoupper($pokemon['name']) ?></h1>

        <div class="battle-container">
            <div class="advantage-box"> 
                 <h3>WEAK AGAINST (2x Damage)</h3>
                 <?php foreach($weaknesses as $w): ?>
                    <span class="type-icon" style="background: var(--<?= $w ?>)"></span>
                <?php endforeach; ?>
            </div>

            <div class="resistance-box">
                <h3> RESISTANT TO (0.5x Damage)</h3>
                <?php foreach($resistances as $r): ?>
                    <span class="type-icon" style="background: var(--<?= $r ?>)"><?= $r ?></span>
                <?php endforeach; ?>
            </div>
        </div>

        <a href="pokemon-detail.php?id=<?= $id ?>" class="btn" style="display: block; text-align: center; margin-top: 40px;">← CLOSE SCANNER</a>
        <div>
    </div>
</body>
</html>