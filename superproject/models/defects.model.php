<?php

function getDefects($pdo) {
    $sql = "SELECT * FROM defects ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getDefectById($pdo, $id) {
    $sql = "SELECT * FROM defects WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addDefect($pdo, $title, $description, $point_id, $created_by, $photo_path = null) {
    $category = 'other';
    $severity = 'medium';
    $status = 'open';

    $sql = "INSERT INTO defects (title, point_id, category, severity, description, photo_path, created_by, status, created_at)
            VALUES (:title, :point_id, :category, :severity, :description, :photo_path, :created_by, :status, NOW())";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':title'       => $title,
        ':point_id'    => $point_id,
        ':category'    => $category,
        ':severity'    => $severity,
        ':description' => $description,
        ':photo_path'  => $photo_path,
        ':created_by'  => $created_by,
        ':status'      => $status
    ]);
}

function updateDefect($pdo, $id, $title, $description, $point_id, $status, $photo_path = null) {
    $sql = "UPDATE defects
            SET title = :title,
                description = :description,
                point_id = :point_id,
                status = :status,
                photo_path = :photo_path
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':title'       => $title,
        ':description' => $description,
        ':point_id'    => $point_id,
        ':status'      => $status,
        ':photo_path'  => $photo_path,
        ':id'          => $id
    ]);
}

function deleteDefect($pdo, $id) {
    $sql = "DELETE FROM defects WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}

function fixDefect($pdo, $id) {
    $sql = "UPDATE defects SET status = 'closed' WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}