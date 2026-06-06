<?php

require_once '../db/connectDB.php';
require_once '../models/materials.model.php';
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $pdo;
    
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $unit = trim($_POST['unit']);
    $quantity = floatval($_POST['quantity']);

    $validTypes = ['cable', 'connector', 'socket', 'fastener'];
    $validUnits = ['m', 'pcs'];

    $error = null;
    
    if (!$id || $id <= 0) {
        $error = "Неверный ID материала";
    } elseif (empty($name)) {
        $error = "Название не может быть пустым";
    } elseif (strlen($name) > 100) {
        $error = "Название не может быть длиннее 100 символов";
    } elseif (!in_array($unit, $validUnits)) {
        $error = "Единица измерения должна быть: m или pcs";
    } elseif ($quantity < 0) {
        $error = "Количество не может быть отрицательным";
    }

    if ($error === null) {
        updateMaterial($pdo, $id, $name, $type, $unit, $quantity);
        header("Location: ../views/materials.view.php?update_success=1");
        exit;
    } else {
        header("Location: ../views/edit.material.view.php?id=" . $id . "&error=" . urlencode($error));
        exit;
    }
}

header("Location: ../views/materials.view.php");
exit;
?>