<?php
if (!defined('APP_LOADED')) {
    die('Прямой доступ запрещен');
}

function getRecentLogs($pdo, $page = 1, $limit = 5) {
    $offset = ($page - 1) * $limit;
    $sql = "SELECT logs.*, users.login 
            FROM logs 
            LEFT JOIN users ON logs.user_id = users.id 
            ORDER BY logs.created_at DESC 
            LIMIT :limit OFFSET :offset";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTotalLogsCount($pdo) {
    $sql = "SELECT COUNT(*) FROM logs";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return (int) $stmt->fetchColumn();
}

function getLogById($pdo, $id) {
    $sql = "SELECT logs.*, users.login 
            FROM logs 
            LEFT JOIN users ON logs.user_id = users.id 
            WHERE logs.id = :id";
     $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
