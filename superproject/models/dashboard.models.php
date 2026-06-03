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
//удалить комнату по id
// function deleteRoomById($pdo, $id) {
//         $stmt = $pdo->prepare('DELETE FROM locations WHERE id = :id');
//         $stmt->execute(['id' => $id]);
//         }



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
//удалить точку сети по id
// function deleteStatsPointById($pdo, $id) {
//         $sql = "DELETE FROM network_points WHERE id = :id";
//         $stmt = $pdo->prepare($sql);
//         $stmt->execute(['id' => $id]);
//         }




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
