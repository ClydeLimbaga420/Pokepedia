<?php
include 'config.php';

$t1 = isset($_GET['t1']) ? $_GET['t1'] : '';
$t2 = isset($_GET['t2']) ? $_GET['t2'] : '';
$results = [];

$all_types = ['Normal', 'Fire', 'Water', 'Grass', 'Electric', 'Ice', 'Fighting', 'Poison', 'Ground', 'Flying', 'Psychic', 'Bug', 'Rock', 'Ghost', 'Dragon', 'Dark', 'Steel', 'Fairy'];

if ($t1 || $t2) {
    $query = "SELECT * FROM pokemon WHERE 1=1";
    $params = [];

    if ($t1 && $t1 !== 'Any') {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $t1; $params[] = $t1;
    }

    if ($t2 && $t2 !== 'Any') {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $t1; $params[] = $t1;
    }

    if ($t2 && $t2 !== 'Any') {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $t2; $params[] = $t2;
    }

    $query .= " ORDER BY pokemon_id ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Type-Search</title>
</head>
<body>
    
    <div class="container">
        <div class="header-section">
            <h2>TYPE MASTER</h2>
            <p>Find the perfect type combination</p>
        </div>

        <div class="search-card">
            <form action="type-search.php" method="GET" class="dropdown-group">
                <select name="t1">
                    <option value="Any">Primary Type</option>
                    <?php foreach($all_types as $type): ?>
                        <option value="<?= $type ?>" <?= $t1 == $type ? 'selected' : '' ?>><?= $type ?></option>
                    <?php endforeach; ?>
                </select>

                <div class="plus-sign">+</div>

                <select name="t2">
                    <option value="Any">Secondary Type</option>
                    <?php foreach($all_types as $type): ?>
                        <option value="<?= $type ?>" <?= $t2 == $type ? 'selected' : '' ?>><?= $type ?></option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="shiny-btn" style="margin-left: 10px; padding: 15px 40px; border-radius: 20px;">
                    FILTER
                </button>
            </form>
        </div>

        <div class="results-grid">
            <?php if ($results): ?>
                <?php foreach ($results as $p): ?>
                    <a href="pokemon-detail.php?id=<?= $p['pokemon_id'] ?>" class="poke-card">
                        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?= $p['pokemon_id'] ?>.png">
                        <p style = "opacity: 0.3;">#<?= sprintf('%03d', $p['pokemon_id']) ?></p>
                        <h4><?= $p['name'] ?></h4>
                        <div style="display: flex; justify-content: center; gap: 8px;">
                            <span class="type-pill <?= strtolower($p['type1']) ?>"><?= $p['type1'] ?></span>
                            <?php if($p['type2']): ?>
                                <span class="type-pill <?= strtolower($p['type2']) ?>"><?= $p['type2'] ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php elseif ($t1 || $t2): ?>
                <div style="grid-column: 1/-1; text-align: center; opacity: 0.5; padding: 50px;">
                    <p>No Pokémon found with that specific typing.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>