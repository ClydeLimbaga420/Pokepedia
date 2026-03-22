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

$stmtPrev = $pdo->prepare("
    SELECT p.pokemon_id, p.name, e.method, e.requirement
    FROM pokemon_evolutions e
    JOIN pokemon p ON e.from_id = p.pokemon_id
    WHERE e.to_id = ?
");
$stmtPrev->execute([$id]);
$parent = $stmtPrev->fetch();

$stmtNext = $pdo->prepare("
    SELECT p.pokemon_id, p.name, e.method, e.requirement
    FROM pokemon_evolutions e
    JOIN pokemon p ON e.to_id = p.pokemon_id
    WHERE e.from_id = ?
");
$stmtNext->execute([$id]);
$children = $stmtNext->fetchAll();

$primaryType = strtolower($pokemon['type1']);
$imagePath = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/" . $pokemon['pokemon_id'] . ".png";

function getStatPercent($val) {
    return ($val / 255) * 100;
}

$stats = [
    'HP' => $pokemon['hp'],
    'Attack' => $pokemon['attack'],
    'Defense' => $pokemon['defense'],
    'Sp. Atk' => $pokemon['special_attack'],
    'Sp. Def' => $pokemon['special_defense'],
    'Speed' => $pokemon['speed']
];

$baseStatTotal = array_sum($stats);

// Tier Logic
if ($baseStatTotal >= 600) {
    $tier = "S-Tier"; $tierColor = "#ff421c";
} elseif ($baseStatTotal >= 500) {
    $tier = "A-Tier"; $tierColor = "#f1c40f";
} else {
    $tier = "B-Tier"; $tierColor = "#95a5a6";
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

        .shiny-btn {
            background: rgba(255, 255,255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 8px 20px;
            border-radius: 30px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.7rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
            backdrop-filter: blur(10px);
            letter-spacing: 1px;
        }

        .shiny-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateU(-2px);
        }

        .shiny-btn.active {
            background: linear-gradient(45deg, #f1c40f, #e67e22);
            border-color: #fff;
            color: #000;
            box-shadow: 0 0 2px rgba(241, 196, 15, 0.6);
        }

        .sparkle {
            margin-right: 5px;
        }

        .battle-link, .battle-fab {
            text-decoration: none;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--<?= $primaryType ?>);
            color: white;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 800;
            letter-spacing: 1px;
            transition: 0.3s;
            display: inline-block;
        }

        .battler-link:hover, .battle-fab:hover {
            background: var(--<?= $primaryType ?>);
            box-shadow: 0 0 20px var(--<?= $primaryType ?>);
            color: #000;
            transform: translateY(-3px);
        }

        @keyframes pulse-radar {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            } 70% {
                box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
            } 100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }

        .battle-fab {
            animation: pulse-radar 2s infinite;
        }

        .info-circle {
            display: inline-flex;
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            color: white;
            text-decoration: none;
            font-size: 0.7rem;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
            transition: 0.3s;
        }

        .info-circle:hover {
            background: var(--<?= $primaryType ?>);
            border-color: white;
            transform: scale(1.2);
        }

        .evolution-section {
            width: 100%;
            margin-top: 50px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 40px;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .evo-flex {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .evo-card {
            text-decoration: none;
            text-align: center;
            transition: 0.3s;
        }

        .evo-img-wrapper {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }

        .evo-card img {
            width: 70%;
            opacity: 0.5;
            filter: grayscale(1);
            transition: 0.3s;
        }

        .evo-card:hover img {
            opacity: 1;
            filter: grayscale(0);
            transform: scale(1.1);
        }

        .evo-card.active-evo img {
            opacity: 1;
            filter: grayscale(0);
        }

        .evo-card p {
            margin: 0;
            font-size: 0.6rem;
            opacity: 0.6;
            color: white;
        }

        .evo-card p span {
            display: block;
            font-size: 0.8rem;
            font-weight: 800;
            opacity: 1;
        }

        .evo-connector {
            display: flex;
            flex-direction: column;
            align-items: center;
            opacity: 0.5;
        }

        .method-label {
            font-size: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .evo-arrow {
            font-size: 1.2rem;
            margin: -5px 0;
        }

        .req-val {
            font-size: 0.7rem;
            font-weight: bold;
            color: var(--<?= $primaryType ?>);
        }

        .evo-branch-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .evo-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-type-pill.fire     { background: var(--fire);     box-shadow: 0 0 20px rgba(255, 66, 28, 0.5); }
        .detail-type-pill.water    { background: var(--water);    box-shadow: 0 0 20px rgba(41, 128, 239, 0.5); }
        .detail-type-pill.grass    { background: var(--grass);    box-shadow: 0 0 20px rgba(98, 188, 90, 0.5); }
        .detail-type-pill.electric { background: var(--electric); box-shadow: 0 0 20px rgba(241, 196, 15, 0.5); color: #000; }
        .detail-type-pill.ice      { background: var(--ice);      box-shadow: 0 0 20px rgba(93, 173, 226, 0.5); }
        .detail-type-pill.fighting { background: var(--fighting); box-shadow: 0 0 20px rgba(192, 57, 43, 0.5); }
        .detail-type-pill.poison   { background: var(--poison);   box-shadow: 0 0 20px rgba(142, 68, 173, 0.5); }
        .detail-type-pill.ground   { background: var(--ground);   box-shadow: 0 0 20px rgba(211, 84, 0, 0.5); }
        .detail-type-pill.flying   { background: var(--flying);   box-shadow: 0 0 20px rgba(127, 140, 141, 0.5); }
        .detail-type-pill.psychic  { background: var(--psychic);  box-shadow: 0 0 20px rgba(155, 89, 182, 0.5); }
        .detail-type-pill.bug      { background: var(--bug);      box-shadow: 0 0 20px rgba(39, 174, 96, 0.5); }
        .detail-type-pill.rock     { background: var(--rock);     box-shadow: 0 0 20px rgba(123, 141, 147, 0.5); }
        .detail-type-pill.ghost    { background: var(--ghost);    box-shadow: 0 0 20px rgba(75, 90, 148, 0.5); }
        .detail-type-pill.dragon   { background: var(--dragon);   box-shadow: 0 0 20px rgba(80, 61, 163, 0.5); }
        .detail-type-pill.dark     { background: var(--dark);     box-shadow: 0 0 20px rgba(44, 62, 80, 0.5); }
        .detail-type-pill.steel    { background: var(--steel);    box-shadow: 0 0 20px rgba(189, 195, 199, 0.5); color: #000; }
        .detail-type-pill.fairy    { background: var(--fairy);    box-shadow: 0 0 20px rgba(233, 30, 99, 0.5); }
        .detail-type-pill.normal   { background: var(--normal);   box-shadow: 0 0 20px rgba(149, 165, 166, 0.5); }

        .detail-type-pill {
            display: inline-block;
            padding: 10px 30px;
            border-radius: 50px;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin: 5px;
            color: white;
            background: #333;
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
                <img id="pokemon-img" src="<?= $imagePath ?>" alt="<?= $pokemon['name'] ?>">

                     <a href="pokemon-battle.php?id=<?= $id ?>" class="battle-fab">
                    <span class="radar-icon"></span> ANALYZE WEAKNESS
                </a>

                <button id="shiny-toggle" class="shiny-btn">
                    <span class="sparkle">✨</span> Shiny Mode
                </button>

               
            </div>

            

            <span class="id-label">#<?= sprintf('%03d', $pokemon['pokemon_id']) ?></span>
            <h1 class="pokemon-name"><?= $pokemon['name'] ?></h1>

            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 10px;">
                <span class="detail-type-pill <?= $primaryType ?>">
                    <?= $pokemon['type1'] ?>
                </span>

                <a href="types-master.php" class="info-circle" title="View Type Chart">?</a>

                <?php if(!empty($pokemon['type2'])): ?>
                    <span class="detail-type-pill <?= strtolower($pokemon['type2']) ?>">
                        <?= $pokemon['type2'] ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="info-section">
            <div class="glass-card">
                

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid rgba(255, 255, 255, 0.1); padding-bottom: 10px;">
                <div>
                    <h2 style="margin: 0; font-weight: 300;">Base Stats</h2>
                    <a href="pokemon-battle.php?id=<?= $id ?>" class="battle-link" style="margin-top: 5px;">
                        BATTLE ANALYSIS

                    </a>
                </div>

            </div>

            <div style="text-align: right">
                    <span style="font-size: 0.7rem; opacity: 0.5; display: block;">BST</span>
                    <span style="font-size: 1.5rem; font-weight: 800; color: <?= $tierColor ?>;"><?= $baseStatTotal ?></span>
                    <span style="font-size: 0.8rem; font-weight: 600; margin-left: 5px; opacity: 0.8;"><?= $tier ?></span>
            </div>
                
                <?php 
                
                



                foreach($stats as $label => $value): ?>
                    <div class="stat-row">
                        <span class="stat-label"><?= $label ?></span>
                        <span class="stat-number"><?= $value ?></span>
                        <div class="stat-bar-bg">
                            <div class="stat-bar-fill" style="width: 0;" data-percent="<?= round(getStatPercent($value)) ?>%"></div>
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
                        <p style="font-size: 0.9rem;"><?= ucfirst($pokemon['ability2']) ?></p>
                        <p style="font-size: 0.9rem;"><?= ucfirst($pokemon['hidden_ability']) ?></p>
                    </div>
                </div>
            </div>
        </div>

         <div class="evolution-section">
         <h3 style="text-transform: uppercase; letter-spacing: 3px; opacity: 0.5; font-size: 0.8rem; margin-bottom: 30px; text-align: center;">Evolutionary Chain</h3>

         <div class="evo-flex">
            <?php if($parent): ?>
                <a href="pokemon-detail.php?id=<?= $parent['pokemon_id'] ?>" class="evo-card">
                    <div class="evo-img-wrapper">
                        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?= $parent['pokemon_id'] ?>.png">
                    </div>
                    <p>#<?= sprintf('%03d', $parent['pokemon_id']) ?> <span><?= strtoupper($parent['name']) ?></span></p>
                </a>

                <div class="evo-connector">
                    <span class="method-label"><?= $parent['method'] ?></span>
                    <div class="evo-arrow">→</div>
                    <span class="req-val"><?= $parent['requirement'] ?></span>
                </div>
            <?php endif; ?>

            <div class="evo-card active-evo">
                <div class="evo-img-wrapper" style="border: 2px solid var(--<?= $primaryType ?>); background: rgba(255, 255, 255, 0.08);">
                   <img src="<?= $imagePath ?>" style="filter: grayscale(0); opacity: 1;">
                </div>
                <p style="color: var(--<?= $primaryType ?>); font-weight: 800;">CURRENT</p>
            </div>

            <?php if($children): ?>
                <div class="evo-branch-container">
                    <?php foreach($children as $child): ?>
                        <div class="evo-row">
                            <div class="evo-connector">
                                <span class="method-label"><?= $child['method'] ?></span>
                                <div class="evo-arrow">→</div>
                                <span class="req-val"><?= $child['requirement'] ?></span>
                            </div>

                            <a href="pokemon-detail.php?id=<?= $child['pokemon_id'] ?>" class="evo-card">
                                <div class="evo-img-wrapper">
                                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?= $child['pokemon_id'] ?>.png">
                                </div>
                                <p>#<?= sprintf('%03d', $child['pokemon_id']) ?><span><?= strtoupper($child['name']) ?></span></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
         </div>
    </div>


    </div>

   
    <script>
        
        window.addEventListener('load', () => {
            const bars = document.querySelectorAll('.stat-bar-fill');

            bars.forEach(bar => {
                const percentage = bar.getAttribute('data-percent');
                void bar.offsetWidth;
                if (percentage) {
                    bar.style.width = percentage;
                }
            });
        });

        const shinyBtn = document.getElementById('shiny-toggle');
        const pokeImg = document.getElementById('pokemon-img');
        const pokemonId = <?= $pokemon['pokemon_id'] ?>
        const defaultUrl = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/${pokemonId}.png`;
        const shinyUrl = `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/shiny/${pokemonId}.png`;

        let isShiny = false;

        shinyBtn.addEventListener('click', () => {
            isShiny = !isShiny;

            pokeImg.style.opacity = '0';
            pokeImg.style.transform = 'scale(0.9) translateY(0)';

            setTimeout(() => {
                pokeImg.src = isShiny ? shinyUrl : defaultUrl;

                shinyBtn.classList.toggle('active');
                shinyBtn.innerHTML = isShiny ? '✨ SHINY ACTIVE' : '✨ SHINY MODE';

                pokeImg.style.opacity = '1';
                pokeImg.style.transform = 'scale(1) translateY(0)';
            }, 250);
        });

    </script>
</body>
</html>