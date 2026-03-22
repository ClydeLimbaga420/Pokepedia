<?php
include 'config.php';

$search = isset($_GEt['q']) ? trim($_GET['q']) : '';
$results = [];

if (!empty($search)) {
    $parts = preg_split('/[\/\s]+/', $search);

    $type1 = $parts[0] ?? '';
    $type2 = $parts[1] ?? '';

    $query = "SELECT * FROM pokemon WHERE 1=1";
    $params = [];

    if ($type1) {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $type1;
        $params[] = $type1;
    }

    if ($type2) {
        $query .= " AND (type1 = ? OR type2 = ?)";
        $params[] = $type2;
        $params[] = $type2;
    }

    $query .= " ORDER BY pokemon_id ASC";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>