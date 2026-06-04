<?php

function getMaterials($pdo){
    $sql = "SELECT * FROM materials";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function useMaterials($pdo, $material_id, $quantity){
    $sql = "UPDATE materials SET quantity = quantity - ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute([$quantity, $material_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
