<?php
include 'config.php';

// Search Logic
$search = isset($_GET['search']) ? $_GET['search'] : '';
$type   = isset($_GET['type']) ? $_GET['type'] : '';

$query = "SELECT * FROM pokemon WHERE name LIKE :search";
$params = [':search' => "%$search%"];

if (!empty($type)) {
    $query .= " AND (type1 = :type OR type2 = :type)";
    $params[':type'] = $type;
}
$query .= " ORDER BY pokemon_id ASC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$pokemonList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poképedia | Encyclopedia</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root { --bg: #0f0f0f; --card: rgba(255, 255, 255, 0.05); --primary: #ff421c; }
        
        body { 
            background: var(--bg); color: white; font-family: 'Poppins', sans-serif; 
            margin: 0; padding: 20px; overflow-x: hidden;
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

        /* Grid Design */
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
            display: inline-block; padding: 3px 10px; border-radius: 5px;
            font-size: 0.7rem; text-transform: uppercase; font-weight: bold; margin: 5px 2px;
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
            </select>
            <button type="submit">Search</button>
        </form>
    </section>

    <main class="pokemon-grid">
    <?php if (count($pokemonList) > 0): ?>
        <?php foreach ($pokemonList as $row): ?>
            <a href="pokemon-detail.php?id=<?= $row['pokemon_id'] ?>" class="card-link">
                <div class="poke-card">
                    <span class="id-badge">#<?= sprintf('%03d', $row['pokemon_id']) ?></span>
                    <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/<?= $row['pokemon_id'] ?>.png" loading="lazy">
                    <h3><?= ucfirst($row['name']) ?></h3>
                    <div class="types">
                        <span class="type-tag <?= strtolower($row['type1']) ?>"><?= $row['type1'] ?></span>
                        <?php if(!empty($row['type2'])): ?>
                            <span class="type-tag <?= strtolower($row['type2']) ?>"><?= $row['type2'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="grid-column: 1/-1; text-align: center; padding: 50px; opacity: 0.5;">
            <p style="font-size: 1.5rem;">No Pokémon found matching your search...</p>
            <a href="index.php" style="color: var(--primary); text-decoration: none;">View All Pokémon</a>
        </div>
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