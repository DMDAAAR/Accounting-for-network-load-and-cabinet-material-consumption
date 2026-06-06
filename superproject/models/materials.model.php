<?php

function getMaterials($pdo){
    $sql = "SELECT * FROM materials";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMaterials($pdo) {
    $sql = "SELECT * FROM materials ORDER BY name";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function useMaterials($pdo, $material_id, $quantity) {
    if ($quantity <= 0) {
        return false;
    }

    $stmt = $pdo->prepare("SELECT quantity FROM materials WHERE id = :id");
    $stmt->execute(['id' => $material_id]);
    $material = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$material) {
        return false;
    }

    $current_quantity = $material['quantity'];

    if ($quantity > $current_quantity) {
        return false;
    }

    $sql = "UPDATE materials SET quantity = quantity - :quantity WHERE id = :material_id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':quantity' => $quantity,
        ':material_id' => $material_id
    ]);
}

function useMaterialsForDefect($pdo, $material_id, $quantity, $defect_id, $user_id) {
    $success = useMaterials($pdo, $material_id, $quantity);
    if (!$success) {
        return false;
    }

    $sql = "INSERT INTO material_usage (material_id, quantity, defect_id, used_by, used_at, comment)
            VALUES (:material_id, :quantity, :defect_id, :used_by, NOW(), :comment)";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':material_id' => $material_id,
        ':quantity'    => $quantity,
        ':defect_id'   => $defect_id,
        ':used_by'     => $user_id,
        ':comment'     => 'Списано при починке дефекта #' . $defect_id
    ]);
}

function insertMaterial($pdo, $name, $type, $unit, $quantity){
    $sql = "INSERT INTO `materials` (`name`, `type`, `unit`, `quantity`) VALUES (:name, :type, :unit, :quantity)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'name' => $name,
        'type' => $type,
        'unit' => $unit,
        'quantity' => $quantity
    ]);
}

function deleteMaterial($pdo, $material_id){
    $sql = "DELETE FROM materials WHERE id = :material_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':material_id' => $material_id]);
    return $stmt->rowCount();
}

function updateMaterial($pdo, $id, $name, $type, $unit, $quantity){
    $sql = "UPDATE `materials` SET
            `name` = :name,
            `type` = :type,
            `unit` = :unit,
            `quantity` = :quantity
            WHERE `id` = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'id' => $id,
        'name' => $name,
        'type' => $type,
        'unit' => $unit,
        'quantity' => $quantity
    ]);
    return $stmt->rowCount();
}