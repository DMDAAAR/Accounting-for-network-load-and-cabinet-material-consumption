<?php

session_start();

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.controller.php');
    exit();
}

require_once '../db/connectDB.php';
require_once '../models/inventory.model.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $label = trim($_POST['label'] ?? '');
        $type = trim($_POST['type'] ?? 'розетка');
        $status = trim($_POST['status'] ?? 'active');
        $location_id = $_POST['location_id'] ?? '';

        if (!empty($label)) {
            addNetworkPoint($pdo, $label, $type, $status, $location_id);
        }
        header('Location: inventory.controller.php');
        exit();
    }
    if (isset($_POST['action']) && $_POST['action'] === 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $label = trim($_POST['label'] ?? '');
        $type = trim($_POST['type'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $location_id = $_POST['location_id'] ?? '';

        if ($id > 0 && !empty($label)) {
            updateNetworkPoint($pdo, $id, $label, $type, $status, $location_id);
        }
        header('Location: inventory.controller.php');
        exit();
    }
}
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = intval($_GET['id'] ?? 0);
    if ($id > 0) {
        deleteNetworkPointById($pdo, $id);
    }
    header('Location: inventory.controller.php');
    exit();
}
$sql = "SELECT network_points.*, locations.name AS location_name 
        FROM network_points 
        LEFT JOIN locations ON network_points.location_id = locations.id 
        ORDER BY network_points.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$points = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rooms = getRooms($pdo); 

require '../views/inventory.view.php';
