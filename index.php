<?php 

include 'config.php'; 

$query = "SELECT * FROM pokemon ORDER BY pokemon_id ASC";
$stmt = $pdo->prepare($query);
$stmt->execute();
$pokemonList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poképedia | Digital Encyclopedia</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

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
</html>