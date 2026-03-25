<?php
include 'config.php';

$search = isset($_GEt['q']) ? trim($_GET['q']) : '';
$results = [];

if (!empty($search)) {
    $parts = preg_split('/[\/\s]+/', $search);

    $type1 = $parts[0] ?? '';
    $type2 = $parts[1] ?? '';

    $query = "SELECT * FROM pokemon WHERE 1=1";
    $params = [];

    if ($type1) {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $type1;
        $params[] = $type1;
    }

    if ($type2) {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $type2;
        $params[] = $type2;
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
    
        .container {
            display: block;
            max-width: 800px;
            margin: 0 auto;
            padding-top: 100px;
        }

        .glass-card {
            margin-bottom: 40px;
            text-align: center;
        }

        .glass-card h2 {
            font-weight: 300;
            letter-spacing: 2px;
        }

        form {
            margin-top: 20px;
        }

        input {
            width: 80%;
            padding: 15px 25px;
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0,0,0,0.3);
            color: white;
            font-family: 'Poppins';
            outline: none;
        }

        .shiny-btn {
            margin-left: -50px;
            padding: 12px 25px;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .glass-card {
            text-decoration: none;
            padding: 20px;
            text-align: center;
            transition: 0.3s;
            display: block;
        }

        img {
            width: 100px;
            margin-bottom: 10px;
        }

        p {
            margin: 0;
            font-size: 0.7rem;
            opacity: 0.5;
        }

        h4 {
            display: flex;
            justify-content: center;
            gap: 5px;

        }

        .detail-type-pill {
            font-size: 0.5rem;
            padding: 4px 10px;
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="glass-card">
            <h2>TYPE EXPLORER</h2>
            <form action="type-search.php" method="GET" >
                 <input type="text" name="q" placeholder="ex: Grass/Poison or Fire/Flying"
            value="<?= htmlspecialchars($search) ?>">
            <button type="submit" class="shiny-btn">SEARCH</button>
            </form>
           
        </div>

        <div class="results-grid">
            <?php if ($results): ?>
                <?php foreach ($results as $p): ?>
                    <a href="pokemon-detail.php?id=<?= $p['pokemon_id'] ?>" class="glass-card">
                        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/pokemon/other/official-network/<?= $p['pokemon_id'] ?>.png">
                        <p>#<?= sprintf('%03d', $p['pokemon_id']) ?></p>
                        <h4><?= $p['name'] ?></h4>
                        <div style="display: flex; justify-content: center; gap: 5px;">
                            <span class="detial-type-pill <?= strtolower($p['type1']) ?>"><?= $p['type1'] ?></span>
                            <?php if($p['type2']): ?>
                                <span class="detail-type-pill <?= strtolower($p['type2']) ?>"><?= $p['type2'] ?></span>
                            <?php endif; ?>
                        </div>
                    </a> 
                <?php endforeach; ?>
                <?php elseif ($search): ?>
                    <p style="text-align: center; opacity: 0.5;">No dual-type matches found for "<?= htmlspecialchars($search) ?>"</p>
                    <?php endif; ?>
        </div>
    </div>

</body>
</html>