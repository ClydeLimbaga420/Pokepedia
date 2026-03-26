<?php
include 'config.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$typeFilter = isset($_GET['type']) ? $_GET['type'] : '';

$types = ['Fire', 'Water', 'Grass', 'Electric', 'Psychic', 'Ice', 'Dragon', 'Dark', 'Fairy', 'Normal', 'Fighting', 'Poison', 'Ground', 'Rock', 'Bug', 'Ghost', 'Steel', 'Flying'  ];

$query = "SELECT * FROM pokemon WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND name LIKE :search";
    $params[':search'] = "%$search%";
}

if (!empty($typeFilter)) {
    $query .= " AND (type1 = :type OR type2 = :type)";
    $params[':type'] = $typeFilter;
}

$query .= " ORDER BY pokemon_id ASC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$pokemonList = $stmt->fetchAll(PDO::FETCH_ASSOC);

$resultCount = count($pokemonList);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poképedia | Encyclopedia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root { --bg: #0f0f0f; --card: rgba(255, 255, 255, 0.05); --primary: #ff421c; 
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
            --flying: #7f8c8d;}
        
        body { 
            background: var(--bg); color: white; font-family: 'Poppins', sans-serif; 
            margin: 0; padding: 20px; overflow-x: hidden;
        }

        .search-form select {
            background: transparent !important;
            border: none;
            color: white;
            padding: 0 15px;
            outline: none;
            font-family: 'Poppins', sans-serif;
            font-size: 0.9rem;
            border-left: 1px solid rgba(255, 255, 255, 0.1);
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
        }

        .search-form select option {
            background: #1a1a1a;
            color: white;
        }

        .search-container { max-width: 700px; margin: 40px auto; }
        .search-form { 
           display: flex;
           align-items: center;
           background: rgba(255, 255, 255, 0.05);
           padding: 5px 10px;
           border-radius: 50px;
           border: 1px solid rgba(255, 255, 255, 0.1);
           backdrop-filter: blur(20px);
        }
       
        .search-form input {
            background: transparent;
            border: none;
            color: white;
            padding: 12px 15px;
            outline: none;
            flex: 1;
            font-size: 1rem;
        }
        .search-form button { 
            background: var(--primary);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
            margin-left: 10px;
        }

        .search-form button:hover {
            filter: brightness(1.2);
            box-shadow: 0 0 15px var(--primary);
        }

        .pokemon-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 25px; max-width: 1200px; margin: 0 auto;
        }

        .card-link { text-decoration: none; color: inherit; }
        
        .poke-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 40px;
            padding: 30px 20px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateY(20px);
        }

        .poke-card:hover { 
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .poke-card::after {
            display: none;
        }

        .poke-card img { 
            width: 130px;
            transition: transform 0.5s ease;
            z-index: 2;
            position: relative;
        }

        .poke-card h3 {
            margin: 15px 0 5px 0;
            font-size: 1.2rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            opacity: 0.9;
        }

        .poke-card:hover img {
            transform: scale(1.1) rotate(5deg);
        }

        .id-badge {
            position: absolute;
            top: 15px;
            right: 20px;
            left: auto;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.2);
        }
        
        .type-tag {
            background: #444;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            text-transform: uppercase;
            margin: 2px;
            display: inline-block;
        }

        header h1 {
            font-size: 4rem;
            font-weight: 800;
            background: linear-gradient(to bottom, #fff 20%, #666 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.5));
            margin: 20px 0;
            text-transform: uppercase;
        }

        .poke-card::after {
            content: ' ';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            transition: 0.8s;
        }

        .poke-card:hover::after {
            left: 100%;
        }

        .poke-card::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 150px;
            background: white;
            filter: blur(50px);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
            transition: 0.6s ease;
            z-index: 1;
        }

        .poke-card:hover::before {
            transform: translate(-50%, -70%) scale(1);
            opacity: 0.1;
        }

        .id-badge {
            position: absolute;
            top: 15px;
            left: 20px;
            font-size: 0.9rem;
            font-weight: 800;
            color: rgba(255,255,255,0.1);
            letter-spacing: 2px;
        }

        .filter-container {
            display: flex;
            gap: 10px;
            padding: 20px;
            overflow-x: auto;
            white-space: nowrap;
            position: sticky;
            top: 0;
            background: rgba(15, 15, 15, 0.8);
            backdrop-filter: blur(10px);
            z-index: 100;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            scrollbar-width: none;
            cursor:grab;
            user-select:none;
            -webkit-user-select: none;
        }

        .filter-btn {
            pointer-events: auto;
        }

        .filter-container:active {
            cursor: grabbing;
        }

        .filter-container::-webkit-scrollbar {
            display: none;
        }

        .filter-btn {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.5);
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 800;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            
        }

        .filter-container::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 50px;
            background: linear-gradient(to right, transparent, var(--bg));
            pointer-events: none;
        }

        .filter-wrapper {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
        }

        .nav-arrow {
            background: rgba(15, 15, 15, 0.8);
            backdrop-filter: blur(10px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            position: absolute;
            z-index: 110;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .nav-arrow:hover {
            background: var(--primary);
            border-color: white;
            transform: scale(1.1);
        }

        .nav-arrow.left {
            left: 10px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .nav-arrow.right {
            right: 10px;
        }

        .filter-container {
            scroll-behavior: smooth;
            padding: 20px 50px;
        }

        .codex-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 800;
            font-size: 0.8rem;
            letter-spacing: 1px;
            transition: 0.3s;
            backdrop-filter: blur(10px);
        }

        .codex-btn:hover {
            background: white;
            color: black;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 255, 255, 0.1);
        }


        .poke-card:hover.primary-fire     { box-shadow: 0 20px 40px rgba(255, 66, 28, 0.3); border-color: var(--fire); }
        .poke-card:hover.primary-water    { box-shadow: 0 20px 40px rgba(41, 128, 239, 0.3); border-color: var(--water); }
        .poke-card:hover.primary-grass    { box-shadow: 0 20px 40px rgba(98, 188, 90, 0.3); border-color: var(--grass); }
        .poke-card:hover.primary-electric { box-shadow: 0 20px 40px rgba(241, 196, 15, 0.3); border-color: var(--electric); }
        .poke-card:hover.primary-psychic  { box-shadow: 0 20px 40px rgba(155, 89, 182, 0.3); border-color: var(--psychic); }
        .poke-card:hover.primary-ice      { box-shadow: 0 20px 40px rgba(93, 173, 226, 0.3); border-color: var(--ice); }
        .poke-card:hover.primary-dragon   { box-shadow: 0 20px 40px rgba(80, 61, 163, 0.3); border-color: var(--dragon); }
        .poke-card:hover.primary-dark     { box-shadow: 0 20px 40px rgba(44, 62, 80, 0.3); border-color: var(--dark); }
        .poke-card:hover.primary-fairy    { box-shadow: 0 20px 40px rgba(233, 30, 99, 0.3); border-color: var(--fairy); }
        .poke-card:hover.primary-normal   { box-shadow: 0 20px 40px rgba(149, 165, 166, 0.3); border-color: var(--normal); }
        .poke-card:hover.primary-fighting { box-shadow: 0 20px 40px rgba(192, 57, 43, 0.3); border-color: var(--fighting); }
        .poke-card:hover.primary-poison   { box-shadow: 0 20px 40px rgba(142, 68, 173, 0.3); border-color: var(--poison); }
        .poke-card:hover.primary-ground   { box-shadow: 0 20px 40px rgba(211, 84, 0, 0.3); border-color: var(--ground); }
        .poke-card:hover.primary-rock     { box-shadow: 0 20px 40px rgba(123, 141, 147, 0.3); border-color: var(--rock); }
        .poke-card:hover.primary-bug      { box-shadow: 0 20px 40px rgba(39, 174, 96, 0.3); border-color: var(--bug); }
        .poke-card:hover.primary-ghost    { box-shadow: 0 20px 40px rgba(75, 90, 148, 0.3); border-color: var(--ghost); }
        .poke-card:hover.primary-steel    { box-shadow: 0 20px 40px rgba(189, 195, 199, 0.3); border-color: var(--steel); }
        .poke-card:hover.primary-flying   { box-shadow: 0 20px 40px rgba(127, 140, 141, 0.3); border-color: var(--flying); }

        .filter-btn.active.fire     { background: var(--fire); border-color: white; color: white; box-shadow: 0 0 15px var(--fire); }
        .filter-btn.active.water    { background: var(--water); border-color: white; color: white; box-shadow: 0 0 15px var(--water); }
        .filter-btn.active.grass    { background: var(--grass); border-color: white; color: white; box-shadow: 0 0 15px var(--grass); }
        .filter-btn.active.electric { background: var(--electric); border-color: white; color: #000; box-shadow: 0 0 15px var(--electric); }
        .filter-btn.active.psychic  { background: var(--psychic); border-color: white; color: white; box-shadow: 0 0 15px var(--psychic); }
        .filter-btn.active.ice      { background: var(--ice); border-color: white; color: white; box-shadow: 0 0 15px var(--ice); }
        .filter-btn.active.dragon   { background: var(--dragon); border-color: white; color: white; box-shadow: 0 0 15px var(--dragon); }
        .filter-btn.active.dark     { background: var(--dark); border-color: white; color: white; box-shadow: 0 0 15px var(--dark); }
        .filter-btn.active.fairy    { background: var(--fairy); border-color: white; color: white; box-shadow: 0 0 15px var(--fairy); }
        .filter-btn.active.normal   { background: var(--normal); border-color: white; color: white; box-shadow: 0 0 15px var(--normal); }
        .filter-btn.active.fighting { background: var(--fighting); border-color: white; color: white; box-shadow: 0 0 15px var(--fighting); }
        .filter-btn.active.poison   { background: var(--poison); border-color: white; color: white; box-shadow: 0 0 15px var(--poison); }
        .filter-btn.active.ground   { background: var(--ground); border-color: white; color: white; box-shadow: 0 0 15px var(--ground); }
        .filter-btn.active.rock     { background: var(--rock); border-color: white; color: white; box-shadow: 0 0 15px var(--rock); }
        .filter-btn.active.bug      { background: var(--bug); border-color: white; color: white; box-shadow: 0 0 15px var(--bug); }
        .filter-btn.active.ghost    { background: var(--ghost); border-color: white; color: white; box-shadow: 0 0 15px var(--ghost); }
        .filter-btn.active.steel    { background: var(--steel); border-color: white; color: #000; box-shadow: 0 0 15px var(--steel); }
        .filter-btn.active.flying   { background: var(--flying); border-color: white; color: white; box-shadow: 0 0 15px var(--flying); }
                
        .filter-btn.active:not([class*=" "]) {
            background: white;
            color:black;
            border-color: white;
        }


        .fire { 
    background: #ff421c; box-shadow: 0 0 10px #ff421c66; 
}
.water {
     background: #2980ef; box-shadow: 0 0 10px #2980ef66; 
    }
.grass {
     background: #62bc5a; box-shadow: 0 0 10px #62bc5a66; 
    }
.electric {
     background: #f1c40f; box-shadow: 0 0 10px #f1c40f66;
     }
.psychic {
     background: #9b59b6; box-shadow: 0 0 10px #9b59b666; 
    }
.ice {
     background: #5dade2; box-shadow: 0 0 10px #5dade266; 
    }
.dragon {
     background: #34495e; box-shadow: 0 0 10px #34495e66;
     }
.dark { 
    background: #2c3e50; box-shadow: 0 0 10px #2c3e5066;
 }
.fairy {
     background: #e91e63; box-shadow: 0 0 10px #e91e6366; 
    }
.normal {
     background: #95a5a6; box-shadow: 0 0 10px #95a5a666;
     }
.fighting {
     background: #c0392b; box-shadow: 0 0 10px #c0392b66; 
    }
.flying {
     background: #7f8c8d; box-shadow: 0 0 10px #7f8c8d66; 
    }
.poison {
     background: #8e44ad; box-shadow: 0 0 10px #8e44ad66; 
    }
.ground {
     background: #d35400; box-shadow: 0 0 10px #d3540066; 
    }
.rock {
     background: #7b8d93; box-shadow: 0 0 10px #7b8d9366; 
    }
.bug {
     background: #27ae60; box-shadow: 0 0 10px #27ae6066; 
    }
.ghost {
     background: #4b5a94; box-shadow: 0 0 10px #4b5a9466; 
    }
.steel 
{ background: #bdc3c7; box-shadow: 0 0 10px #bdc3c766; 
}
    </style>
</head>
<body>


    <div class="top-nav" style="display: flex; gap: 15px; margin-bottom: 20px;">
        <a href="types-master.php" class="codex-btn"> 
            <span class="icon">📜</span> TYPE CODEX
        </a>
        <a href="type-search.php" class="codex-btn search-alt">
            <span class="icon">🔍</span> ADVANCED TYPE SEARCH
        </a>
    </div>

    <header style="text-align: center; margin-bottom: 20px;">
        <h1 style="font-size: 3rem; letter-spacing: 2px;">POKÉPEDIA</h1>
    </header>


    <section class="search-container">
        <form class="search-form" method="GET" action="index.php">
            <span style="margin-left: 15px; opacity: 0.5;">🔍</span>

            <input type="text" name="search" placeholder="Search by name..." value="<?= htmlspecialchars($search) ?>">

            <select name="type">
                <option value="">All Types</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= $t ?>" <?= ($typeFilter == $t) ? 'selected' : '' ?>>
                        <?= $t ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">GO</button>
        </form>
    </section>

    <div class="filter-wrapper">
        <button class="nav-arrow left" onclick="scrollFilter(-200)">&#10094;</button>
            <div class="filter-container" id="type-bar">
                <a href="index.php" class="filter-btn <?= !$typeFilter ? 'active' : '' ?>">ALL</a>

                    <?php
        
                        foreach ($types as $t):
                    ?>

                        <a href="index.php?type=<?= $t ?>" class="filter-btn <?= ($typeFilter == $t) ? 'active' : '' ?> <?= strtolower($t) ?>">
                        <?= strtoupper($t) ?>

                    </a>

                    <?php endforeach; ?>
            </div>

            <button class="nav-arrow right" onclick="scrollFilter(200)">&#10095;</button>
    </div>

    <div style="max-width: 1200px; margin: 20px auto; padding: 0 20px; opacity: 0.6; font-size: 0.9rem;">
        Showing <strong><?= $resultCount ?><strong> Pokémon
        <?php if($typeFilter) echo "of type <strong>$typeFilter</strong>"; ?>
        <?php if($search) echo " matching \"<strong>$search</strong>\""; ?>

    </div>

    <main class="pokemon-grid">
        <?php if (count($pokemonList) >0): ?>
            <?php foreach ($pokemonList as $row): ?>
                <a href="pokemon-detail.php?id=<?= $row['pokemon_id'] ?>" class="card-link">
                    <div class="poke-card primary-<?= strtolower($row['type1']) ?>">
                        <span class="id-badge">#<?= sprintf('%03d', $row['pokemon_id']) ?></span>
                        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?= $row['pokemon_id'] ?>.png" loading="lazy">

                        <h3><?= ucfirst($row['name']) ?></h3>

                        <div class="types">
                            <span class="type-tag <?= strtolower($row['type1']) ?>">
                                <?= $row['type1'] ?>
                            </span>

                            <?php if (!empty($row['type2'])): ?>
                                <span class="type-tag <?= strtolower($row['type2']) ?>">
                                    <?= $row['type2'] ?>
                                </span>
                                <?php endif; ?>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; grid-column: 1/-1;">No Pokémon Found.</p>
                <?php endif; ?>

    </main>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        
        const cards = document.querySelectorAll('.poke-card');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 40);
        });

        const slider = document.getElementById('type-bar');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.style.cursor = 'grabbing';
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => { isDown = false; slider.style.cursor = 'grab'; });
        slider.addEventListener('mouseup', () => { isDown = false; slider.style.cursor = 'grab'; });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });

        const leftBtn = document.querySelector('.nav-arrow.left');
        slider.addEventListener('scroll', () => {
            if (slider.scrollLeft <= 10) {
                leftBtn.style.opacity = '0';
                leftBtn.style.pointerEvents = 'none';
            } else {
                leftBtn.style.opacity = '1';
                leftBtn.style.pointerEvents = 'auto';
            }
        });
    });

    
    function scrollFilter(amount) {
        const bar = document.getElementById('type-bar');
        if(bar) {
            bar.scrollBy({
                left: amount,
                behavior: 'smooth'
            });
        }
    }
</script>
</body>
</html>