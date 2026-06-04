<?php
//получить все комнаты
function getRooms($pdo) {
    $stmt = $pdo->query('SELECT * FROM locations WHERE type = "room"');
    $stmt->execute();
    return $stmt->fetchAll();
}

//получить одну комнату по id
function getRoomById($pdo, $id) {
    $stmt = $pdo->prepare('SELECT * FROM locations WHERE id = :id');
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

//получить все точки сети
function getStatsPoints($pdo) {
    $sql = "SELECT * FROM network_points";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

//получить одну точку сети по id
function getStatsPointById($pdo, $id) {
    $sql = "SELECT * FROM network_points WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

//получить все открытые дефекты
function getOpenDefects($pdo) {
    $sql = "SELECT * FROM defects WHERE status = 'open'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

//получить один дефект по id
function getDefectById($pdo, $id) {
    $sql = "SELECT * FROM defects WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}

//получить все материалы
function getMaterialUsage($pdo) {
    $sql = "SELECT * FROM material_usage";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

//функция чтобы вытащить ID точки, её имя и реальное название кабинета/зоны.
function getAllPoints($pdo){
    $sql = "
        SELECT
            np.id,
            np.label,
            np.type,
            np.status,
            np.last_check,
            loc1.name AS location_name,
            loc2.name AS location_end_name
        FROM network_points np
        LEFT JOIN locations loc1 ON np.location_id = loc1.id
        LEFT JOIN locations loc2 ON np.location_end_id = loc2.id
        ORDER BY np.id ASC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//  Новые функции для подзадачи 9.2


 // Получить список точек сети с поиском и пагинацией.

function getFilteredPoints(PDO $pdo, string $search, int $limit, int $offset): array
{
    $sql = "
        SELECT
            np.id, np.label, np.type, np.status, np.last_check,
            loc1.name AS location_name,
            loc2.name AS location_end_name
        FROM network_points np
        LEFT JOIN locations loc1 ON np.location_id = loc1.id
        LEFT JOIN locations loc2 ON np.location_end_id = loc2.id
        WHERE 1=1
    ";
    $params = [];
    if (!empty($search)) {
        $sql .= " AND (np.label LIKE :s1 OR loc1.name LIKE :s2 OR loc2.name LIKE :s3)";
        $term = '%' . $search . '%';
        $params[':s1'] = $term;
        $params[':s2'] = $term;
        $params[':s3'] = $term;
    }
    $sql .= " ORDER BY np.id ASC LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


 // Подсчитать общее количество записей с учётом поиска.

function getTotalFilteredPoints(PDO $pdo, string $search): int
{
    $sql = "
        SELECT COUNT(*)
        FROM network_points np
        LEFT JOIN locations loc1 ON np.location_id = loc1.id
        LEFT JOIN locations loc2 ON np.location_end_id = loc2.id
        WHERE 1=1
    ";
    $params = [];
    if (!empty($search)) {
        $sql .= " AND (np.label LIKE :s1 OR loc1.name LIKE :s2 OR loc2.name LIKE :s3)";
        $term = '%' . $search . '%';
        $params[':s1'] = $term;
        $params[':s2'] = $term;
        $params[':s3'] = $term;
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return (int) $stmt->fetchColumn();
}