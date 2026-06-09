<?php
session_start();

define('APP_LOADED', true);
define('BASE_URL', '/superproject/');
// Проверяем, зашел ли пользователь
if (!isset($_SESSION['user'])) {
    header('Location: login.controller.php');
    exit();
}

require_once '../db/connectDB.php';
require_once '../models/inventory.model.php';
require_once '../models/logs.model.php';

$userId = $_SESSION['user']['id'];


$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$points = getFilteredPoints($pdo, $search, $limit, $offset);
$totalPoints = getTotalFilteredPoints($pdo, $search);
$totalPages = ceil($totalPoints / $limit);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $label = trim($_POST['label'] ?? '');
    $type = trim($_POST['type'] ?? 'socket');
    $status = trim($_POST['status'] ?? 'active');
    $location_id = $_POST['location_id'] ?? null;

    if (!empty($label)) {
        $newId = addNetworkPoint($pdo, $label, $type, $status, $location_id);
        addLog($pdo, $userId, "Добавил точку: $label", 'network_points', 0);
        $_SESSION['flash_success'] = "Точка '$label' добавлена";
        
        if ($status === 'defect'){
            $_SESSION['flash_info'] = "Пожалуйста, подробно опишите неисправность точки '$label'";
            header("Location: defects.controller.php?point_id=" . $newId);
            exit;
        }
    } else {
        $_SESSION['flash_error'] = "Название точки не может быть пустым";
    }

    header('Location: inventory.controller.php');
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {
    $id = (int)($_POST['id'] ?? 0);
    $label = trim($_POST['label'] ?? '');
    $type = trim($_POST['type'] ?? 'socket');
    $status = trim($_POST['status'] ?? 'active');
    $location_id = $_POST['location_id'] ?? null;

    if ($id > 0 && !empty($label)) {
        updateNetworkPoint($pdo, $id, $label, $type, $status, $location_id);
        addLog($pdo, $userId, "Изменил точку: $label", 'network_points', $id);
        $_SESSION['flash_success'] = "Точка '$label' обновлена";
        
        if ($status === 'defect'){
            $_SESSION['flash_info'] = "Пожалуйста, подробно опишите неисправность точки '$label'";
            header("Location: defects.controller.php?point_id=" . $id);
            exit;
        }
    } else {
        $_SESSION['flash_error'] = "Ошибка при обновлении";
    }

    header('Location: inventory.controller.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = (int)($_GET['id'] ?? 0);

    if ($id > 0) {
        $stmt = $pdo->prepare("SELECT label FROM network_points WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $point = $stmt->fetch();

        deleteNetworkPointById($pdo, $id);
        addLog($pdo, $userId, "Удалил точку: " . ($point['label'] ?? "ID $id"), 'network_points', $id);
        $_SESSION['flash_success'] = "Точка удалена";
    }

    header('Location: inventory.controller.php');
    exit();
}

$edit_point = null;
if (isset($_GET['edit_id'])) {
    $edit_id = (int)$_GET['edit_id'];
    if ($edit_id > 0) {
        $edit_point = getStatsPointById($pdo, $edit_id);
    }
}

$rooms = getRooms($pdo);


require '../views/inventory.view.php';
?>