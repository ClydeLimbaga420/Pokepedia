<?php
include 'config.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

$stmt = $pdo->prepare("SELECT * FROM pokemon WHERE pokemon_id = ?");
$stmt->execute([$id]);
$pokemon = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pokemon) { header("Location: index.php"); exit; }

$primaryType = strtolower($pokemon['type1']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= ucfirst($pokemon['name']) ?> | Poképedia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            margin: 0; padding: 0; color: white; font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at center, #2c3e50 0%, #000 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
        }

        /* Dynamic background logic */
        .bg-fire { background: radial-gradient(circle at center, #8a2313 0%, #000 100%); }
        .bg-water { background: radial-gradient(circle at center, #134e8a 0%, #000 100%); }
        .bg-grass { background: radial-gradient(circle at center, #1c5d19 0%, #000 100%); }

        .container { width: 90%; max-width: 1000px; display: flex; flex-wrap: wrap; gap: 40px; position: relative; }
        
        .visual-section { flex: 1; text-align: center; }
        .main-artwork { width: 100%; max-width: 400px; animation: float 4s ease-in-out infinite; filter: drop-shadow(0 20px 30px rgba(0,0,0,0.6)); }
        
        .info-section { flex: 1; background: rgba(255,255,255,0.05); padding: 40px; border-radius: 30px; backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); }
        
        .stat-row { display: flex; align-items: center; margin-bottom: 15px; }
        .stat-label { width: 80px; font-size: 0.8rem; opacity: 0.6; }
        .stat-bar-bg { flex: 1; height: 8px; background: rgba(255,255,255,0.1); border-radius: 10px; margin-left: 10px; overflow: hidden; }
        .stat-bar-fill { height: 100%; transition: width 1.5s ease-out; }

        /* Specific Type Colors for Bars */
        .fill-fire { background: #ff421c; box-shadow: 0 0 10px #ff421c; }
        .fill-water { background: #2980ef; box-shadow: 0 0 10px #2980ef; }
        .fill-grass { background: #62bc5a; box-shadow: 0 0 10px #62bc5a; }

        .nav-btn { position: absolute; top: -50px; color: white; text-decoration: none; opacity: 0.5; font-weight: bold; transition: 0.3s; }
        .nav-btn:hover { opacity: 1; }

        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
    </style>
</head>
<body class="bg-<?= $primaryType ?>">

    <div class="container">
        <a href="index.php" class="nav-btn" style="left: 0;">← Gallery</a>
        <a href="pokemon-detail.php?id=<?= $id + 1 ?>" class="nav-btn" style="right: 0;">Next Pokémon →</a>

        <div class="visual-section">
            <img class="main-artwork" src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?= $pokemon['pokemon_id'] ?>.png">
            <h1 style="font-size: 3.5rem; margin: 10px 0;"><?= ucfirst($pokemon['name']) ?></h1>
            <p>Region: <?= ucfirst($pokemon['region']) ?> | Gen: <?= $pokemon['generation'] ?></p>
        </div>

        <div class="info-section">
            <h3>Base Statistics</h3>
            <?php 
            $stats = ['HP' => 'hp', 'ATK' => 'attack', 'DEF' => 'defense', 'SPD' => 'speed'];
            foreach($stats as $label => $col): 
                $val = $pokemon[$col];
                $percent = ($val / 255) * 100;
            ?>
                <div class="stat-row">
                    <span class="stat-label"><?= $label ?></span>
                    <span style="font-weight:bold; width: 30px;"><?= $val ?></span>
                    <div class="stat-bar-bg">
                        <div class="stat-bar-fill fill-<?= $primaryType ?>" style="width: <?= $percent ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 30px;">
                <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 15px; text-align: center;">
                    <span style="font-size: 0.7rem; opacity: 0.5;">HEIGHT</span>
                    <p style="margin: 5px 0; font-weight: bold;"><?= $pokemon['height']/10 ?> m</p>
                </div>
                <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 15px; text-align: center;">
                    <span style="font-size: 0.7rem; opacity: 0.5;">WEIGHT</span>
                    <p style="margin: 5px 0; font-weight: bold;"><?= $pokemon['weight']/10 ?> kg</p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>