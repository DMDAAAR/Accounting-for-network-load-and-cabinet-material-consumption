<?php

if (!function_exists('getRooms')) {
    function getRooms($pdo) {
        $stmt = $pdo->query('SELECT * FROM locations WHERE type = "room"');
        return $stmt->fetchAll();
    }
}

if (!function_exists('getRoomById')) {
    function getRoomById($pdo, $id) {
        $stmt = $pdo->prepare('SELECT * FROM locations WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}

if (!function_exists('getStatsPoints')) {
    function getStatsPoints($pdo) {
        $sql = "SELECT * FROM network_points";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

if (!function_exists('getStatsPointById')) {
    function getStatsPointById($pdo, $id) {
        $sql = "SELECT * FROM network_points WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}

if (!function_exists('getOpenDefects')) {
    function getOpenDefects($pdo) {
        $sql = "SELECT * FROM defects WHERE status = 'open'";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

if (!function_exists('getDefectById')) {
    function getDefectById($pdo, $id) {
        $sql = "SELECT * FROM defects WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}

if (!function_exists('getMaterialUsage')) {
    function getMaterialUsage($pdo) {
        $sql = "SELECT * FROM material_usage";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

if (!function_exists('getAllPoints')) {
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
}

if (!function_exists('getFilteredPoints')) {
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
}

if (!function_exists('getTotalFilteredPoints')) {
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
}

if (!function_exists('addNetworkPoint')) {
    function addNetworkPoint($pdo, $label, $type, $status, $location_id) {
        $sql = "INSERT INTO network_points (label, type, status, location_id, last_check) 
                VALUES (:label, :type, :status, :location_id, NOW())";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':label'       => $label,
            ':type'        => $type,
            ':status'      => $status,
            ':location_id' => !empty($location_id) ? $location_id : null
        ]);
    }
}

if (!function_exists('deleteNetworkPointById')) {
    function deleteNetworkPointById($pdo, $id) {
        $sql = "DELETE FROM network_points WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}

if (!function_exists('updateNetworkPoint')) {
    function updateNetworkPoint($pdo, $id, $label, $type, $status, $location_id) {
        $sql = "UPDATE network_points 
                SET label = :label, 
                    type = :type, 
                    status = :status, 
                    location_id = :location_id 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            ':id'          => $id,
            ':label'       => $label,
            ':type'        => $type,
            ':status'      => $status,
            ':location_id' => !empty($location_id) ? intval($location_id) : null
        ]);
    }
}

if (!function_exists('getMaterialsUsedForPoint')) {
    function getMaterialsUsedForPoint($pdo, $point_id) {
        $sql = "
            SELECT 
                m.name AS material_name,
                mu.quantity,
                m.unit,
                mu.used_at,
                u.login AS user_name
            FROM material_usage mu
            JOIN materials m ON mu.material_id = m.id
            JOIN users u ON mu.used_by = u.id
            LEFT JOIN defects d ON mu.defect_id = d.id
            WHERE mu.point_id = :point_id1 
               OR (mu.defect_id IS NOT NULL AND d.point_id = :point_id2)
            ORDER BY mu.used_at DESC
        ";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':point_id1' => $point_id,
            ':point_id2' => $point_id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
