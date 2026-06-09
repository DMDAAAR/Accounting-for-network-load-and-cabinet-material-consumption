<?php
// models/dashboard.model.php - добавляем новые функции в конец файла
if (!function_exists('getDefectsCountByPoint')) {

    function getDefectsCountByPoint($pdo) {
        $sql = "SELECT point_id, COUNT(*) as count
                FROM defects
                WHERE status IN ('open', 'in_progress')
                GROUP BY point_id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $defectsCount = [];
        foreach ($results as $row) {
            $defectsCount[$row['point_id']] = (int)$row['count'];
        }

        return $defectsCount;
    }
}
if (!function_exists('buildCabinetScheme')) {

    function buildCabinetScheme($points, $defectsCount) {
        $rows = 3;
        $cols = 5;


        $pointsByLabel = [];
        foreach ($points as $point) {
            $pointsByLabel[$point['label']] = $point;
        }


        $scheme = [];
        $counter = 1;

        for ($row = 0; $row < $rows; $row++) {
            $scheme[$row] = [];
            for ($col = 0; $col < $cols; $col++) {
                $expectedLabel = "Розетка-" . str_pad($counter, 2, '0', STR_PAD_LEFT);

                if (isset($pointsByLabel[$expectedLabel])) {
                    $point = $pointsByLabel[$expectedLabel];
                    $pointId = $point['id'];
                    $hasDefect = isset($defectsCount[$pointId]) && $defectsCount[$pointId] > 0;

                    $scheme[$row][$col] = [
                        'id' => $pointId,
                        'label' => $point['label'],
                        'type' => $point['type'],
                        'status' => $point['status'],
                        'hasDefect' => $hasDefect,
                        'exists' => true
                    ];
                } else {
                    $scheme[$row][$col] = [
                        'id' => null,
                        'label' => "Место $counter",
                        'type' => null,
                        'status' => null,
                        'hasDefect' => false,
                        'exists' => false
                    ];
                }
                $counter++;
            }
        }

        return $scheme;
    }
}
if (!function_exists('getNetworkDevices')) {
    function getNetworkDevices($pdo, $defectsCount) {
        // Получаем все коммутаторы
        $sqlSwitches = "SELECT * FROM network_points WHERE type = 'switch'";
        $stmt = $pdo->prepare($sqlSwitches);
        $stmt->execute();
        $switches = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Добавляем информацию о дефектах для коммутаторов
        foreach ($switches as &$switch) {
            $switch['hasDefect'] = isset($defectsCount[$switch['id']]) && $defectsCount[$switch['id']] > 0;
        }

        // Получаем все розетки
        $sqlSockets = "SELECT * FROM network_points WHERE type = 'socket' ORDER BY label";
        $stmt = $pdo->prepare($sqlSockets);
        $stmt->execute();
        $sockets = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Добавляем информацию о дефектах для розеток
        foreach ($sockets as &$socket) {
            $socket['hasDefect'] = isset($defectsCount[$socket['id']]) && $defectsCount[$socket['id']] > 0;
        }

        return [
            'switches' => $switches,
            'sockets' => $sockets
        ];
    }
}
?>