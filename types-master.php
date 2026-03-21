<?php

$chart = [
    'normal'   => ['rock'=>0.5, 'ghost'=>0, 'steel'=>0.5],
    'fire'     => ['fire'=>0.5, 'water'=>0.5, 'grass'=>2, 'ice'=>2, 'bug'=>2, 'rock'=>0.5, 'dragon'=>0.5, 'steel'=>2],
    'water'    => ['fire'=>2, 'water'=>0.5, 'grass'=>0.5, 'ground'=>2, 'rock'=>2, 'dragon'=>0.5],
    'grass'    => ['fire'=>0.5, 'water'=>2, 'grass'=>0.5, 'poison'=>0.5, 'ground'=>2, 'flying'=>0.5, 'bug'=>0.5, 'rock'=>2, 'dragon'=>0.5, 'steel'=>0.5],
    'electric' => ['water'=>2, 'grass'=>0.5, 'electric'=>0.5, 'ground'=>0, 'flying'=>2, 'dragon'=>0.5],
    'ice'      => ['fire'=>0.5, 'water'=>0.5, 'grass'=>2, 'ice'=>0.5, 'ground'=>2, 'flying'=>2, 'dragon'=>2, 'steel'=>0.5],
    'fighting' => ['normal'=>2, 'ice'=>2, 'poison'=>0.5, 'flying'=>0.5, 'psychic'=>0.5, 'bug'=>0.5, 'rock'=>2, 'ghost'=>0, 'dark'=>2, 'steel'=>2, 'fairy'=>0.5],
    'poison'   => ['grass'=>2, 'poison'=>0.5, 'ground'=>0.5, 'rock'=>0.5, 'ghost'=>0.5, 'steel'=>0, 'fairy'=>2],
    'ground'   => ['fire'=>2, 'grass'=>0.5, 'electric'=>2, 'poison'=>2, 'flying'=>0, 'bug'=>0.5, 'rock'=>2, 'steel'=>2],
    'flying'   => ['grass'=>2, 'electric'=>0.5, 'fighting'=>2, 'bug'=>2, 'rock'=>0.5, 'steel'=>0.5],
    'psychic'  => ['fighting'=>2, 'poison'=>2, 'psychic'=>0.5, 'dark'=>0, 'steel'=>0.5],
    'bug'      => ['fire'=>0.5, 'grass'=>2, 'fighting'=>0.5, 'poison'=>0.5, 'flying'=>0.5, 'psychic'=>2, 'ghost'=>0.5, 'dark'=>2, 'steel'=>0.5, 'fairy'=>0.5],
    'rock'     => ['fire'=>2, 'ice'=>2, 'fighting'=>0.5, 'ground'=>0.5, 'flying'=>2, 'bug'=>2, 'steel'=>0.5],
    'ghost'    => ['normal'=>0, 'psychic'=>2, 'ghost'=>2, 'dark'=>0.5],
    'dragon'   => ['dragon'=>2, 'steel'=>0.5, 'fairy'=>0],
    'dark'     => ['fighting'=>0.5, 'psychic'=>2, 'ghost'=>2, 'dark'=>0.5, 'fairy'=>0.5],
    'steel'    => ['fire'=>0.5, 'water'=>0.5, 'electric'=>0.5, 'ice'=>2, 'rock'=>2, 'steel'=>0.5, 'fairy'=>2],
    'fairy'    => ['fire'=>0.5, 'fighting'=>2, 'poison'=>0.5, 'dragon'=>2, 'dark'=>2, 'steel'=>0.5]
];

$allTypes = array_keys($chart);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon Types</title>

    <style>

        body{
            background: #0f0f0f;
            font-family: 'Poppins', sans-serif;
            color: white;
            margin: 0;
            padding: 40px;
        }

        .page-title {
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 50px;
        }

        .types-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .type-master-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s ease;
            display: flex;
            flex-direction: column;
        }

        .type-master-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.07);
            box-shadow: 0 15px 30px rgba(0,0,0,0.5);
        }

        .type-header {
            padding: 25px 15px;
            text-align: center;
        }

        .type-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 3px;
            text-shadow: 0 0 15px rgba(0,0,0,0.5);
        }

        .type-body {
            padding: 20px;
            flex-grow: 1;
        }


        .stat-group {
            margin-bottom: 20px;
            background: rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 15px;
        }

        .stat-group small {
            display: block;
            font-weight: 800;
            font-size: 0.65rem;
            margin-bottom: 10px;
            opacity: 0.6;
            letter-spacing: 1.5px;
        }

        .mini-pills {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .pill {
            font-size: 0.7rem;
            padding: 6px 12px;
            border-radius: 8px;
            text-transform: uppercase;
            font-weight: bold;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .danger-text {
            color: #ff421c;
        }

        .safe-text {
            color: #62bc5a;
        }

        i {
            font-size: 0.6rem;
            opacity: 0.8;
            font-style: normal;
            display: block;
        }

        .border-normal { border-bottom: 4px solid #A8A878; }
        .border-fire { border-bottom: 4px solid #F08030; }
        .border-water { border-bottom: 4px solid #6890F0; }
        .border-electric { border-bottom: 4px solid #F8D030; }
        .border-grass { border-bottom: 4px solid #78C850; }
        .border-ice { border-bottom: 4px solid #98D8D8; }
        .border-fighting { border-bottom: 4px solid #C03028; }
        .border-poison { border-bottom: 4px solid #A040A0; }
        .border-ground { border-bottom: 4px solid #E0C068; }
        .border-flying { border-bottom: 4px solid #A890F0; }
        .border-psychic { border-bottom: 4px solid #F85888; }
        .border-bug { border-bottom: 4px solid #A8B820; }
        .border-rock { border-bottom: 4px solid #B8A038; }
        .border-ghost { border-bottom: 4px solid #705898; }
        .border-dragon { border-bottom: 4px solid #7038F8; }
        .border-dark { border-bottom: 4px solid #705848; }
        .border-steel { border-bottom: 4px solid #B8B8D0; }
        .border-fairy { border-bottom: 4px solid #EE99AC; }
    </style>
</head>
<body>
    
    <h1 class="page-title">Type Codex</h1>

<div class="types-grid">
    <?php foreach ($allTypes as $type): ?>
        <div class="type-master-card border-<?= $type ?>">
            <div class="type-header">
                <h2 style="color: var(--<?= $type ?>)"><?= strtoupper($type) ?></h2>
            </div>

            <div class="type-body">
                <div class="stat-group">
                    <small>ATTACK EFFECTIVENESS</small>
                    <div class="mini-pills">
                        <?php 
                        foreach($chart[$type] as $target => $mult) {
                            if($mult == 2) echo "<span class='pill'>$target <i>2x</i></span>";
                        }
                        ?>
                    </div>
                </div>

                <div class="stat-group">
                    <small class="danger-text">VULNERABLE TO (Receives 2x)</small>
                    <div class="mini-pills">
                        <?php 
                        foreach($chart as $attacker => $targets) {
                            if(isset($targets[$type]) && $targets[$type] == 2) {
                                echo "<span class='pill' style='border-color: #ff421c'>$attacker</span>";
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="stat-group">
                    <small class="safe-text">RESISTANT TO</small>
                    <div class="mini-pills">
                        <?php 
                        foreach($chart as $attacker => $targets) {
                            if(isset($targets[$type]) && $targets[$type] < 1) {
                                $label = ($targets[$type] == 0) ? "Immune" : "0.5x";
                                echo "<span class='pill'>$attacker <i>$label</i></span>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>