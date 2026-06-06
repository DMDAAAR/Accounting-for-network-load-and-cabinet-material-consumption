<?php

/**
 * Получить все дефекты (журнал неисправностей)
 * @param PDO $pdo
 * @return array
 */
function getDefects($pdo) {
    $sql = "SELECT * FROM defects ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Получить один дефект по ID (для редактирования)
 * @param PDO $pdo
 * @param int $id
 * @return array|false
 */
function getDefectById($pdo, $id) {
    $sql = "SELECT * FROM defects WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Добавить новый дефект
 * @param PDO $pdo
 * @param string $title
 * @param string $description
 * @param int $point_id
 * @param int $created_by (ID пользователя из сессии)
 * @return bool
 */
function addDefect($pdo, $title, $description, $point_id, $created_by) {
    // Значения по умолчанию для обязательных полей таблицы
    $category = 'other';
    $severity = 'medium';
    $photo_path = null;
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

/**
 * Обновить дефект (название, описание, точку, статус)
 * @param PDO $pdo
 * @param int $id
 * @param string $title
 * @param string $description
 * @param int $point_id
 * @param string $status
 * @return bool
 */
function updateDefect($pdo, $id, $title, $description, $point_id, $status) {
    $sql = "UPDATE defects 
            SET title = :title, 
                description = :description, 
                point_id = :point_id, 
                status = :status 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':title'       => $title,
        ':description' => $description,
        ':point_id'    => $point_id,
        ':status'      => $status,
        ':id'          => $id
    ]);
}

/**
 * Удалить дефект по ID
 * @param PDO $pdo
 * @param int $id
 * @return bool
 */
function deleteDefect($pdo, $id) {
    $sql = "DELETE FROM defects WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}