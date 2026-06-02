<?php
function getAllPoints($pdo) {
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
