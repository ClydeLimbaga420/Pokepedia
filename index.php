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
            background: rgba(255,255,255,0.05) !important;
            border-radius: 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        .search-form select option {
            background: #1a1a1a;
            color: white;
        }

        .search-container { max-width: 700px; margin: 40px auto; }
        .search-form { 
            display: flex; background: var(--card); padding: 8px; 
            border-radius: 50px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);
        }
        .search-form input, .search-form select { 
            background: transparent; border: none; color: white; padding: 10px 15px; outline: none; flex: 1;
        }
        .search-form button { 
            background: var(--primary); color: white; border: none; 
            padding: 10px 25px; border-radius: 30px; cursor: pointer; font-weight: 600;
        }

        .pokemon-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 25px; max-width: 1200px; margin: 0 auto;
        }

        .card-link { text-decoration: none; color: inherit; }
        
        .poke-card {
            background: var(--card); border-radius: 20px; padding: 20px; text-align: center;
            border: 1px solid rgba(255,255,255,0.1); transition: 0.4s;
            opacity: 0; transform: translateY(20px); /* For JS animation */
        }

        .poke-card:hover { transform: translateY(-10px); border-color: var(--primary); }
        .poke-card img { width: 130px; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.4)); }
        
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

    <header style="text-align: center; margin-bottom: 20px;">
        <h1 style="font-size: 3rem; letter-spacing: 2px;">POKÉPEDIA</h1>
    </header>

    <section class="search-container">
        <form class="search-form" method="GET">
            <input type="text" name="search" placeholder="Search Pokémon..." value="<?= htmlspecialchars($search) ?>">
            <select name="type" onchange="this.form.submit()">  
                <option value="">All Types</option>
                <?php foreach ($types as $t): ?>
                    <option value="<?= $t ?>" <?= ($typeFilter == $t) ? 'selected' : '' ?>>
                        <?= $t ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Search</button>
        </form>
    </section>

    <div class="filter-container">
        <a href="index.php" class="filter-btn <?= !$typeFilter ? 'active' : '' ?>">ALL</a>

        <?php
        
        foreach ($types as $t):
        ?>

            <a href="index.php?type=<?= $t ?>" class="filter-btn <?= ($typeFilter == $t) ? 'active' : '' ?> <?= strtolower($t) ?>">
                <?= strtoupper($t) ?>

            </a>

        <?php endforeach; ?>
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
                    <div class="poke-card">
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
        });
    </script>
</body>
</html>