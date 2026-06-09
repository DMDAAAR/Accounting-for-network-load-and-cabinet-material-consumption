<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}

function getTotalComputers($pdo) {
    $sql = "SELECT COUNT(*) FROM locations WHERE type = 'workspace' AND room_number = '319Б'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

function getNetworkPointsStats($pdo) {
    $sql = "SELECT status, COUNT(*) as count FROM network_points GROUP BY status";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stats = ['active' => 0, 'defect' => 0, 'decommissioned' => 0];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if (isset($stats[$row['status']])) {
            $stats[$row['status']] = (int)$row['count'];
        }
    }
    return $stats;
}

function getMaterialsUsageStats($pdo) {
    // Расход кабеля (в метрах)
    $sqlCable = "SELECT SUM(mu.quantity) as total 
                 FROM material_usage mu
                 LEFT JOIN materials m ON mu.material_id = m.id
                 WHERE m.type = 'cable' AND m.unit = 'm'";
    $stmt = $pdo->prepare($sqlCable);
    $stmt->execute();
    $cableUsed = (float)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

    // Расход коннекторов (в штуках)
    $sqlConnector = "SELECT SUM(mu.quantity) as total 
                     FROM material_usage mu
                     LEFT JOIN materials m ON mu.material_id = m.id
                     WHERE m.type = 'connector' AND m.unit = 'pcs'";
    $stmt = $pdo->prepare($sqlConnector);
    $stmt->execute();
    $connectorUsed = (float)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

    // Расход розеток (в штуках)
    $sqlSocket = "SELECT SUM(mu.quantity) as total 
                  FROM material_usage mu
                  LEFT JOIN materials m ON mu.material_id = m.id
                  WHERE m.type = 'socket' AND m.unit = 'pcs'";
    $stmt = $pdo->prepare($sqlSocket);
    $stmt->execute();
    $socketUsed = (float)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

    // Общее количество операций расхода
    $sqlTotalOps = "SELECT COUNT(*) as total FROM material_usage";
    $stmt = $pdo->prepare($sqlTotalOps);
    $stmt->execute();
    $totalOperations = (int)($stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

    return [
        'cable' => ['used' => $cableUsed, 'unit' => 'м', 'label' => 'Кабель'],
        'connector' => ['used' => $connectorUsed, 'unit' => 'шт', 'label' => 'Коннекторы'],
        'socket' => ['used' => $socketUsed, 'unit' => 'шт', 'label' => 'Розетки'],
        'operations' => ['used' => $totalOperations, 'unit' => 'опер.', 'label' => 'Операций']
    ];
}

function getMaterialsRemainingStats($pdo) {
    $sql = "SELECT type, SUM(quantity) as total FROM materials 
            WHERE type IN ('cable','connector','socket')
            GROUP BY type";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stats = ['cable' => 0, 'connector' => 0, 'socket' => 0];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $stats[$row['type']] = (float)$row['total'];
    }
    return $stats;
}

function getSwitchPortsData($pdo) {
    $sql = "SELECT id, label, status FROM network_points 
            WHERE type IN ('socket', 'patch_cord') 
            ORDER BY id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $points = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $sqlDefects = "SELECT DISTINCT point_id FROM defects 
                   WHERE status IN ('open', 'in_progress') 
                   AND point_id IS NOT NULL";
    $stmtDef = $pdo->prepare($sqlDefects);
    $stmtDef->execute();
    $defectivePoints = $stmtDef->fetchAll(PDO::FETCH_COLUMN);
    $defectiveMap = array_flip($defectivePoints);

    $ports = [];
    for ($i = 1; $i <= 24; $i++) {
        $ports[$i] = [
            'port' => $i,
            'color' => 'gray',
            'point_id' => null
        ];
    }

    foreach ($points as $point) {
        $pointId = $point['id'];
        if ($pointId >= 1 && $pointId <= 24) {
            $ports[$pointId]['point_id'] = $pointId;
            if (isset($defectiveMap[$pointId])) {
                $ports[$pointId]['color'] = 'red';
            } else {
                $ports[$pointId]['color'] = ($pointId <= 12) ? 'green' : 'blue';
            }
        }
    }

    return $ports;
}
?>