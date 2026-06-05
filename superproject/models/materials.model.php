<?php

function getMaterials($pdo){
    $sql = "SELECT * FROM materials";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function useMaterials($pdo, $material_id, $quantity){
    $sql = "UPDATE materials SET quantity = quantity - :quantity WHERE id = :material_id";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute([':quantity' => $quantity, ':material_id' => $material_id]);
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
?>