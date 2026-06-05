<?php
require '../db/connectDB.php';
require '../models/materials.model.php';
session_start();

$material_id = $_POST['material_id'] ?? null;
$quantity = $_POST['quantity'] ?? null;

if ($material_id && is_numeric($quantity)) {
    $result = useMaterials($pdo, $material_id, (float)$quantity);

    if ($result === true) {
        $_SESSION['message_success'] = "Материал успешно списан.";
    } else {
        $_SESSION['message_error'] = "Ошибка: Недостаточно материала или неверные данные.";
    }
}

header("Location: ../views/materials.view.php");
exit();
