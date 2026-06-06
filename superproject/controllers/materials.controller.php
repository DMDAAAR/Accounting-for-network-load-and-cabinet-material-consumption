<?php
define('APP_LOADED', true);
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
session_start();

require_once '../db/connectDB.php';
require_once '../models/materials.model.php';

// Обработка POST (добавление, обновление, удаление)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Удаление
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['delete_id'])) {
        $material_id = (int)$_POST['delete_id'];
        if (deleteMaterial($pdo, $material_id)) {
            $_SESSION['flash_success'] = "Материал #$material_id удалён";
        } else {
            $_SESSION['flash_error'] = "Ошибка при удалении";
        }
        header('Location: materials.controller.php');
        exit();
    }

    $id = isset($_POST['id']) && !empty($_POST['id']) ? (int)$_POST['id'] : null;
    $name = trim($_POST['name'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $unit = trim($_POST['unit'] ?? '');
    $quantity = isset($_POST['quantity']) ? floatval($_POST['quantity']) : 0;

    $validTypes = ['cable', 'connector', 'socket', 'fastener'];
    $validUnits = ['m', 'pcs'];

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
        if ($id) {

            $rows = updateMaterial($pdo, $id, $name, $type, $unit, $quantity);
            if ($rows !== false) {
                $_SESSION['flash_success'] = "Материал #$id обновлён";
            } else {
                $_SESSION['flash_error'] = "Ошибка при обновлении";
            }
        } else {
            // Добавление
            insertMaterial($pdo, $name, $type, $unit, $quantity);
            $_SESSION['flash_success'] = "Материал успешно добавлен";
        }
    } else {
        $_SESSION['flash_error'] = $error;
        if ($id) {
            header("Location: materials.controller.php?edit_id=$id");
        } else {
            header("Location: materials.controller.php");
        }
        exit();
    }

    header('Location: materials.controller.php');
    exit();
}

$editableMaterial = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    if ($edit_id > 0) {
        $stmt = $pdo->prepare("SELECT * FROM materials WHERE id = :id");
        $stmt->execute(['id' => $edit_id]);
        $editableMaterial = $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$materials = getMaterials($pdo);

include '../views/materials.view.php';