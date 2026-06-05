<?php

require_once '../db/connectDB.php';
require_once '../models/materials.model.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $pdo;
    
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $unit = trim($_POST['unit']);
    $quantity = floatval($_POST['quantity']);

    // Допустимые значения для ENUM полей
    $validTypes = ['cable', 'connector', 'socket', 'fastener'];
    $validUnits = ['m', 'pcs'];

    // Валидация
    $error = null;
    
    if (empty($name)) {
        $error = "Название не может быть пустым";
    } elseif (strlen($name) > 100) {
        $error = "Название не может быть длиннее 100 символов";
    } elseif (!in_array($type, $validTypes)) {
        $error = "Тип должен быть одним из: " . implode(', ', $validTypes);
    } elseif (!in_array($unit, $validUnits)) {
        $error = "Единица измерения должна быть: m или pcs";
    } elseif ($quantity < 0) {
        $error = "Количество не может быть отрицательным";
    }

    if ($error === null) {
        insertMaterial($pdo, $name, $type, $unit, $quantity);
        header("Location: ../views/materials.view.php");
        exit;
    } else {
        header("Location: ../views/create.materials.view.php?error=" . urlencode($error));
        exit;
    }
}

header("Location: ../views/materials.view.php");
exit;
?>