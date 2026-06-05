<?php

function getMaterials($pdo){
    $sql = "SELECT * FROM materials";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function useMaterials($pdo, $material_id, $quantity) {
    // Проверяем, что количество положительное
    if ($quantity <= 0) {
        return false; // Возвращаем false для некорректного ввода
    }

    // Шаг 1: Получаем текущий остаток материала из базы
    $stmt = $pdo->prepare("SELECT quantity FROM materials WHERE id = :id");
    $stmt->execute(['id' => $material_id]);
    $material = $stmt->fetch(PDO::FETCH_ASSOC);

    // Если материал не найден
    if (!$material) {
        return false;
    }

    $current_quantity = $material['quantity'];

    // Шаг 2: Сравниваем запрошенное количество с текущим остатком
    if ($quantity > $current_quantity) {
        // Недостаточно материалов! Не выполняем запрос к БД.
        return false;
    }

    // Шаг 3: Если остатка достаточно - выполняем списание
    $sql = "UPDATE materials SET quantity = quantity - :quantity WHERE id = :material_id";
    $stmt = $pdo->prepare($sql);
    $stmt -> execute([
        ':quantity' => $quantity,
        ':material_id' => $material_id
    ]);

    return true; // Успешно списали
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
