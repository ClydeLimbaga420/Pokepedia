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

    <style>
        :root {
            --accent: #008080;
            --glass: rgba(255, 255, 255, 0.5);
        }

        body {
            background: #0f0f0f;
            color: white;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            min-height: 100vh;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 50% 10%, var(--accent), transparent 50%);
            opacity: 0.15;
            z-index: -1;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 80px 20px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 50px;
        }

        .header-section h2 {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: 5px;
            margin: 0;
            background: linear-gradient(to bottom, #fff, #666);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .search-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 40px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .dropdown-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        select {
            background: rgba(0,0,0,0.4);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px 25px;
            border-radius: 20px;
            font-family:'Poppins';
            font-size: 1rem;
            width: 200px;
            outline: none;
            cursor: pointer;
            transition: 0.3s;
        }

        select:focus {
            border-color: var(--select);
            box-shadow: 0 0 15px rgba(0, 128, 128, 0.3);
        }

        .plus-sign {
            font-size: 1.5rem;
            font-weight: 800;
            opacity: 0.3;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
            margin-top: 60px;
        }

        .poke-card {
            background: var(--glass);
            border-radius: 30px;
            padding: 25px;
            text-align: center;
            text-decoration: none;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), background 0.3s;
        }

        .poke-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent);
        }

        .poke-card img {
            width: 120px;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.4));
        }

        .poke-card h4 {
            margin: 15px 0 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .type-pill {
            font-size: 0.6rem;
            padding: 5px 12px;
            border-radius: 50px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-block;
        }
    </style>

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