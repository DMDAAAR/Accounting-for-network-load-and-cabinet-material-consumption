<?php
function getDefects($pdo) {
    $sql = "SELECT * FROM defects ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $defects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $defects;
}
function addDefect($pdo, $point_id, $category, $severity, $description, $photo_path, $created_by) {
    $sql = "INSERT INTO defects (point_id, category, severity, description, photo_path, created_by, status, created_at) 
            VALUES (:point_id, :category, :severity, :description, :photo_path, :created_by, 'open', NOW())";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':point_id' => $point_id,
        ':category' => $category,
        ':severity' => $severity,
        ':description' => $description,
        ':photo_path' => $photo_path,
        ':created_by' => $created_by
    ]);
    if ($result) {
        return $pdo->lastInsertId();
    } else {
        return false;
    }
}
?>
