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

function getStatPercent($val) {
    return ($val / 255) * 100;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst($pokemon['name']) ?> | Poképedia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --fire: #ff421c; 
            --water: #2980ef; 
            --grass: #62bc5a; 
            --electric: #f1c40f;
            --psychic: #9b59b6; 
            --ice: #5dade2; 
            --dragon: #503da3; 
            --dark: #2c3e50;
            --fairy: #e91e63; 
            --normal: #95a5a6; 
            --fighting: #c0392b; 
            --poison: #8e44ad;
            --ground: #d35400; 
            --rock: #7b8d93; 
            --bug: #27ae60; 
            --ghost: #4b5a94; 
            --steel: #bdc3c7;
            --flying: #7f8c8d;
        }

        body {
            margin: 0; 
            padding: 0; 
            font-family: 'Poppins', sans-serif; 
            color: white;
            background: #0f0f0f; 
            min-height: 100vh;
            display: flex; 
            align-items: center; 
            justify-content: center;
            overflow-x: hidden;
        }

        
        .type-bg {
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            z-index: -1;
            background: radial-gradient(circle at 50% 40%, var(--<?= $primaryType ?>), #000 70%);
            opacity: 0.4;
        }

        .container {
            width: 90%;
             max-width: 1100px; 
             display: flex; 
             flex-wrap: wrap; 
             gap: 50px; 
             align-items: center; 
             position: relative; 
             padding: 40px 0;
        }

        .visual-section { 
            flex: 1; 
            text-align: center; 
            min-width: 320px; }
        
        .artwork-container { 
            position: relative;
         }
        .artwork-container img {
            width: 100%; 
            max-width: 450px; 
            z-index: 5; 
            position: relative;
            filter: drop-shadow(0 20px 50px rgba(0,0,0,0.8));
            animation: float 5s ease-in-out infinite;
        }

        .pokemon-name { 
            font-size: 4rem; 
            font-weight: 800; 
            margin: 0; 
            text-transform: uppercase; 
            letter-spacing: -2px; 
        }
        .id-label {
             font-size: 1.5rem; 
             opacity: 0.3; 
             font-weight: 800;
        }

        .info-section {
             flex: 1.2; 
             min-width: 350px; 
            }

        .glass-card {
            background: rgba(255, 255, 255, 0.03); 
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1); 
            padding: 40px; 
            border-radius: 40px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.3);
        }

        .stat-row { 
            display: flex; 
            align-items: center; 
            margin-bottom: 18px; 
        }
        .stat-label { 
            width: 90px; 
            font-size: 0.75rem; 
            font-weight: 600; 
            opacity: 0.5; 
            text-transform: uppercase; 
        }
        .stat-number { 
            width: 40px; 
            font-weight: bold; 
            font-size: 1rem; 
        }
        
        .stat-bar-bg { 
            flex: 1; 
            height: 10px; 
            background: rgba(255, 255, 255, 0.1); 
            border-radius: 20px; 
            margin-left: 15px; 
            overflow: hidden; 
        }
        .stat-bar-fill { 
            height: 100%; 
            width: 0; 
            background: var(--<?= $primaryType ?>); 
            box-shadow: 0 0 15px var(--<?= $primaryType ?>);
            border-radius: 20px; 
            transition: width 1.5s cubic-bezier(0.17, 0.67, 0.83, 0.67); 
        }

        
        .details-grid { 
            display: grid; 
            grid-template-columns: repeat(3, 1fr); 
            gap: 15px; 
            margin-top: 30px; 
        }
        .mini-card { 
            background: rgba(255,255,255,0.05); 
            padding: 20px; 
            border-radius: 20px; 
            text-align: center; 
        }
        .mini-card span { 
            display: block; 
            font-size: 0.65rem; 
            opacity: 0.5; 
            margin-bottom: 5px; 
            font-weight: bold; 
        }
        .mini-card p { 
            margin: 0; 
            font-weight: bold; 
            font-size: 1.1rem; 
        }

        
        .nav-links { 
            position: absolute; 
            top: 0; 
            width: 100%; 
            display: flex; 
            justify-content: space-between; 
        }
        .btn { 
            text-decoration: none; 
            color: white; 
            font-weight: bold; 
            opacity: 0.4; 
            transition: 0.3s; 
            padding: 10px; 
        }
        .btn:hover { 
            opacity: 1; 
            transform: scale(1.1); 
        }

        @keyframes float { 0%, 100% { 
            transform: translateY(0); } 50% { 
                transform: translateY(-25px); } }

        @media (max-width: 768px) {
            .container { 
                flex-direction: column; 
                text-align: center; 
            }
            .pokemon-name { 
                font-size: 3rem; 
            }
        }
    </style>
</head>
<body>

    <div class="type-bg"></div>

    <div class="container">
        <div class="nav-links">
            <a href="index.php" class="btn">← GALLERY</a>
            <div>
                <?php if($id > 1): ?>
                    <a href="pokemon-detail.php?id=<?= $id - 1 ?>" class="btn">PREV</a>
                <?php endif; ?>
                <a href="pokemon-detail.php?id=<?= $id + 1 ?>" class="btn">NEXT</a>
            </div>
        </div>

        <div class="visual-section">
            <div class="artwork-container">
                <img src="<?= $imagePath ?>" alt="<?= $pokemon['name'] ?>">
            </div>
            <span class="id-label">#<?= sprintf('%03d', $pokemon['pokemon_id']) ?></span>
            <h1 class="pokemon-name"><?= $pokemon['name'] ?></h1>
            <div style="margin-top: 15px;">
                <span style="background: var(--<?= $primaryType ?>); padding: 8px 25px; border-radius: 50px; font-weight: bold; text-transform: uppercase; font-size: 0.9rem;">
                    <?= $pokemon['type1'] ?>
                </span>
            </div>
        </div>

        <div class="info-section">
            <div class="glass-card">
                <h2 style="margin-top: 0; margin-bottom: 30px; font-weight: 300;">Base Statistics</h2>
                
                <?php 
                $stats = [
                    'HP' => $pokemon['hp'],
                    'Attack' => $pokemon['attack'],
                    'Defense' => $pokemon['defense'],
                    'Sp. Atk' => $pokemon['special_attack'],
                    'Sp. Def' => $pokemon['special_defense'],
                    'Speed' => $pokemon['speed']
                ];

                foreach($stats as $label => $value): ?>
                    <div class="stat-row">
                        <span class="stat-label"><?= $label ?></span>
                        <span class="stat-number"><?= $value ?></span>
                        <div class="stat-bar-bg">
                            <div class="stat-bar-fill" data-percent="<?= getStatPercent($value) ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="details-grid">
                    <div class="mini-card">
                        <span>HEIGHT</span>
                        <p><?= $pokemon['height'] / 10 ?>m</p>
                    </div>
                    <div class="mini-card">
                        <span>WEIGHT</span>
                        <p><?= $pokemon['weight'] / 10 ?>kg</p>
                    </div>
                    <div class="mini-card">
                        <span>ABILITY</span>
                        <p style="font-size: 0.9rem;"><?= ucfirst($pokemon['ability1']) ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        window.addEventListener('DOMContentLoaded', () => {
            const bars = document.querySelectorAll('.stat-bar-fill');
            setTimeout(() => {
                bars.forEach(bar => {
                    bar.style.width = bar.getAttribute('data-percent');
                });
            }, 300);
        });
    </script>
</body>
</html>