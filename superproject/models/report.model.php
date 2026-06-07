<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}

function getFilteredDefects($pdo, $date_from, $date_to, $category, $point_type, $status) {
    $sql = "SELECT 
                defects.id, 
                defects.title, 
                defects.category, 
                defects.severity, 
                defects.description, 
                defects.status, 
                defects.created_at,
                network_points.label AS point_label, 
                network_points.type AS point_type,
                locations.name AS location_name, 
                users.login AS creator_login
            FROM defects
            LEFT JOIN network_points ON defects.point_id = network_points.id
            LEFT JOIN locations ON network_points.location_id = locations.id
            LEFT JOIN users ON defects.created_by = users.id
            WHERE 1=1";

    $params = [];

    if (!empty($date_from)) {
        $sql .= " AND defects.created_at >= :date_from";
        $params[':date_from'] = $date_from . ' 00:00:00';
    }

    if (!empty($date_to)) {
        $sql .= " AND defects.created_at <= :date_to";
        $params[':date_to'] = $date_to . ' 23:59:59';
    }

    if ($category !== 'all' && !empty($category)) {
        $sql .= " AND defects.category = :category";
        $params[':category'] = $category;
    }

    if ($point_type !== 'all' && !empty($point_type)) {
        $sql .= " AND network_points.type = :point_type";
        $params[':point_type'] = $point_type;
    }

    if ($status !== 'all' && !empty($status)) {
        $sql .= " AND defects.status = :status";
        $params[':status'] = $status;
    }

    $sql .= " ORDER BY defects.created_at DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getUniqueDefectCategories($pdo) {
    $sql = "SELECT DISTINCT category FROM defects WHERE category IS NOT NULL AND category != ''";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}