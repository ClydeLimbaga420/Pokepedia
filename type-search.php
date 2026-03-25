<?php
include 'config.php';

$t1 = isset($_GET['t1']) ? $_GET['t1'] : '';
$t2 = isset($_GET['t2']) ? $_GET['t2'] : '';
$results = [];

$all_types = ['Normal', 'Fire', 'Water', 'Grass', 'Electric', 'Ice', 'Fighting', 'Poison', 'Ground', 'Flying', 'Psychic', 'Bug', 'Rock', 'Ghost', 'Dragon', 'Dark', 'Steel', 'Fairy'];

if ($t1 || $t2) {
    $query = "SELECT * FROM pokemon WHERE 1=1";
    $params = [];

    if ($t1 && $t1 !== 'Any') {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $t1; $params[] = $t1;
    }

    if ($t2 && $t2 !== 'Any') {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $t1; $params[] = $t1;
    }

    if ($t2 && $t2 !== 'Any') {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $t2; $params[] = $t2;
    }

    $query .= " ORDER BY pokemon_id ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>