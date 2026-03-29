<?php
include 'config.php';

$stmt = $pdo->query("SELECT pokemon_id, name, type1, type2, hp, attack, defense, special_attack, special_defense, speed FROM pokemon ORDER BY name ASC");
$all_pokemon = $stmt->fetchAll(PDO::FETCH_ASSOC);

$winner = null;
$p1 = null;
$p2 = null;

if (isset($_POST['battle'])) {
    $p1_id = $_POST['p1'];
    $p2_ID = $_POST['p2'];

    $stmt = $pdo->prepare("SELECT * FROM pokemon WHERE pokemon_id = ?" );
    $stmt->execute([$p1_id]);
    $p1 = $stmt->fetch();

    $stmt->execute([$p2_id]);
    $p2 = $stmt->fetch();

    $p1_score = ($p1['hp'] + $p1['attack'] + $p1['defense'] + $p1['special_attack'] + $p1['special_defense'] + $p1['speed']) * (1 + ($p1['type1'] == $p2['type1'] || $p1['type1'] == $p2['type2'] ? 0.2 : 0) + ($p1['type2'] && ($p1['type2'] == $p2['type1'] || $p1['type2'] == $p2['type2']) ? 0.2 : 0));
    $p2_score = ($p2['hp'] + $p2['attack'] + $p2['defense'] + $p2['special_attack'] + $p2['special_defense'] + $p2['speed']) * (1 + ($p2['type1'] == $p1['type1'] || $p2['type1'] == $p1['type2'] ? 0.2 : 0) + ($p2['type2'] && ($p2['type2'] == $p1['type1'] || $p2['type2'] == $p1['type2']) ? 0.2 : 0));

    if ($p1_score > $p2_score) {
        $winner = $p1['name'];
    } elseif ($p2_score > $p1_score) {
        $winner = $p2['name'];
    } else {
        $winner = "It's a tie!";
    }
}
?>