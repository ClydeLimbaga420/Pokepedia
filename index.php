<?php 

include 'config.php'; 

$search = isset($_GET['search']) ? $_GET['search'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';

$query = "SELECT * FROM pokemon WHERE name LIKE :search";
$params = [':search' => "%$search%"];

if (!empty($type)) {
    $query .= " AND (type1 = :type OR type2 = :type)";
    $params['type'] = $type;
}

$query .= " ORDER BY pokemon_id ASC";

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $pokemonList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poképedia | Digital Encyclopedia</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <section class="search-container">
        <form action="index.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search Pokémon by name..." value="<?= $_GET['search'] ?? '' ?>">
                <select name="type">
                    <option value="">All Types</option>
                    <option value="Normal">Normal</option>
                    <option value="Fire">Fire</option>
                    <option value="Water">Water</option>
                    <option value="Electric">Electric</option>
                    <option value="Grass">Grass</option>
                    <option value="Ice">Ice</option>
                    <option value="Fighting">Fighting</option>
                    <option value="Poison">Poison</option>
                    <option value="Ground">Ground</option>
                    <option value="Flying">Flying</option>
                    <option value="Psychic">Psychic</option>
                    <option value="Bug">Bug</option>
                    <option value="Rock">Rock</option>
                    <option value="Ghost">Ghost</option>
                    <option value="Dragon">Dragon</option>
                    <option value="Dark">Dark</option>
                    <option value="Steel">Steel</option>
                    <option value="Fairy">Fairy</option>
                </select>
        </form>
    </section>


    <header class="main-header">
        <h1>Poképedia</h1>
    </header>

    <main class="pokemon-grid">
        <?php foreach ($pokemonList as $row): 
            
            $imagePath = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/" . $row['pokemon_id'] . ".png";
        ?>
            <a href="pokemon-detail.php?id=<?= $row['pokemon_id'] ?>" class="card-link">
                <div class='poke-card' data-type='<?= strtolower($row['type1']) ?>'>
                    <span class='id-badge'>#<?= sprintf('%03d', $row['pokemon_id']) ?></span>
                    
                    <div class="img-container">
                        <img src='<?= $imagePath ?>' alt='<?= $row['name'] ?>' loading="lazy">
                    </div>

                    <h3><?= ucfirst($row['name']) ?></h3>
                    
                    <div class='types'>
                        <span class='type-tag <?= strtolower($row['type1']) ?>'>
                            <?= $row['type1'] ?>
                        </span>
                        
                        <?php if(!empty($row['type2'])): ?>
                            <span class='type-tag <?= strtolower($row['type2']) ?>'>
                                <?= $row['type2'] ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
    </main>

</body>

<script src="assets/js/main.js"></script>
</html>