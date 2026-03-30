<?php
include 'config.php';

$stmt = $pdo->query("SELECT pokemon_id, name, type1, type2, hp, attack, defense, special_attack, special_defense, speed FROM pokemon ORDER BY name ASC");
$all_pokemon = $stmt->fetchAll(PDO::FETCH_ASSOC);

$winner = null;
$p1 = null;
$p2 = null;

if (isset($_POST['battle'])) {
    $p1_id = $_POST['p1'];
    $p2_ID = $_POST['p2'];

    $stmt = $pdo->prepare("SELECT * FROM pokemon WHERE pokemon_id = ?" );
    $stmt->execute([$p1_id]);
    $p1 = $stmt->fetch();

    $stmt->execute([$p2_id]);
    $p2 = $stmt->fetch();

    $p1_score = ($p1['hp'] + $p1['attack'] + $p1['defense'] + $p1['special_attack'] + $p1['special_defense'] + $p1['speed']) * (1 + ($p1['type1'] == $p2['type1'] || $p1['type1'] == $p2['type2'] ? 0.2 : 0) + ($p1['type2'] && ($p1['type2'] == $p2['type1'] || $p1['type2'] == $p2['type2']) ? 0.2 : 0));
    $p2_score = ($p2['hp'] + $p2['attack'] + $p2['defense'] + $p2['special_attack'] + $p2['special_defense'] + $p2['speed']) * (1 + ($p2['type1'] == $p1['type1'] || $p2['type1'] == $p1['type2'] ? 0.2 : 0) + ($p2['type2'] && ($p2['type2'] == $p1['type1'] || $p2['type2'] == $p1['type2']) ? 0.2 : 0));

    if ($p1_score > $p2_score) {
        $winner = $p1['name'];
    } elseif ($p2_score > $p1_score) {
        $winner = $p2['name'];
    } else {
        $winner = "It's a tie!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BATTLE</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    
    <h1 style="letter-spacing: 5px; font-weight: 300;">BATTLE <span style="font-weight: 800; color: var(--gold);">ARENA</span></h1>

    <form method="POST" style="display: contents;">
        <div class="arena">
            <div class="fighter-card">
                <select name="p1">
                    <?php foreach ($all_pokemon as $poke): ?>
                        <option value="<?= $poke['pokemon_id'] ?>" <?= ($p1 && $p1['pokemon_id'] == $poke['id']) ? 'selected' : '' ?>>
                            <?= strtoupper($poke['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if ($p1): ?>
                    <div class="stats">
                        <p><span class="stat-label">ATK</span> <span class="stat-val"><?= $p1['attack'] ?></span></p>
                        <p><span class="stat-label">DEF</span> <span class="stat-val"><?= $p1['defense'] ?></span></p>
                        <p><span class="stat-label">SP.ATK</span> <span class="stat-val"><?= $p1['special_attack'] ?></span></p>
                        <p><span class="stat-label">SP.DEF</span> <span class="stat-val"><?= $p1['special_defense'] ?></span></p>
                        <p><span class="stat-label">SPD</span> <span class="stat-val"><?= $p1['speed'] ?></span></p>
                    </div>
                <?php endif; ?>
            </div>

            <div class="vs-badge">VS</div> 

            <div class="fighter-card">
                <select name="p2">
                    <?php foreach ($all_pokemon as $poke): ?>
                        <option value="<?= $poke['pokemon_id'] ?>" <?= ($p2 && $p2['pokemon_id'] == $poke['pokemon_id']) ? 'selected' : '' ?>>
                            <?= strtoupper($poke['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($p2): ?>
                    <div class="stats">
                        <p><span class="stat-label">ATK</span> <span class="stat-val"><?= $p2['attack'] ?></span></p>
                        <p><span class="stat-label">DEF</span> <span class="stat-val"><?= $p2['defense'] ?></span></p>
                        <p><span class="stat-label">SP.ATK</span> <span class="stat-val"><?= $p2['special_attack'] ?></span></p>
                        <p><span class="stat-label">SP.DEF</span> <span class="stat-val"><?= $p2['special_defense'] ?></span></p>
                        <p><span class="stat-label">SPD</span> <span class="stat-val"><?= $p2['speed'] ?></span></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <buttton type="submit" name="battle" class="battle-btn">INITIATE BATTLE</buttton>
    </form>

    <?php if ($winner): ?>
        <div class="result-overlay">
            <h2 style="margin: 0; font-weight: 300;">WINNER: <span style="font-weight: 800; color: var(--gold);"><?= strtoupper($winner) ?></span></h2>
        </div>
    <?php endif; ?>

    <a href="index.php" style="margin-top: 40px; color: #666; text-decoration: none; font-size: 0.8rem">← RETURN TO POKÉPEDIA</a>

</body>
</html>
