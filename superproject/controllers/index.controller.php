<?php
// controllers/index.controller.php
session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.controller.php');
    exit();
}
define('APP_LOADED', true);
define('BASE_URL', '/superproject/');
require_once '../db/connectDB.php';
require_once '../models/inventory.model.php';
require_once '../models/dashboard.model.php';
require_once '../models/logs.model.php';
$userId = $_SESSION['user']['id'];
$userRole = $_SESSION['user']['role'];
// Получаем все сетевые точки
$allPoints = getStatsPoints($pdo);
// Получаем количество дефектов для каждой точки
$defectsCount = getDefectsCountByPoint($pdo);
// Формируем схему кабинета
$cabinetScheme = buildCabinetScheme($allPoints, $defectsCount);
// Получаем сетевые устройства для схемы соединений
$networkDevices = getNetworkDevices($pdo, $defectsCount);
// Получаем логи только для администратора
$logs = [];
$totalLogPages = 1;
$log_page = 1;
if ($userRole === 'admin') {
    $log_limit = 5;
    $log_page = isset($_GET['log_page']) ? max(1, intval($_GET['log_page'])) : 1;
    $logs = getRecentLogs($pdo, $log_page, $log_limit);
    $totalLogsCount = getTotalLogsCount($pdo);
    $totalLogPages = ceil($totalLogsCount / $log_limit);
}
// Подключаем представление
require '../views/index.view.php';
?>
