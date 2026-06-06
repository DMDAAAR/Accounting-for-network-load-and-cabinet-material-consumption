<?php

session_start();
if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    header('Location: login.controller.php');
    exit();
}
define('APP_LOADED', true);

require_once '../db/connectDB.php';
require_once '../models/inventory.model.php';
require_once '../models/logs.model.php';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$limit = 5; 
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

$data = getFilteredPoints($pdo, $search, $limit, $offset);
$totalPoints = getTotalFilteredPoints($pdo, $search);
$totalPages = ceil($totalPoints / $limit);

$log_limit = 5; 
$log_page = isset($_GET['log_page']) ? max(1, intval($_GET['log_page'])) : 1;

$logs = getRecentLogs($pdo, $log_page, $log_limit);
$totalLogsCount = getTotalLogsCount($pdo);
$totalLogPages = ceil($totalLogsCount / $log_limit);

require '../views/index.view.php';