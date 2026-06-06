<?php
require_once 'db/connectDB.php';
require_once 'models/dashboard.model.php';

define('APP_LOADED', true);
define('BASE_URL', '/superproject/');   // <-- исправлено

dashboardIndex($pdo);
$StatsPoints = getStatsPoints($pdo);
$StatsPointsById = getStatsPointById($pdo, $_GET);
$RoomById = getRoomById($pdo, $_GET);
$OpenDefens = getOpenDefects($pdo);
$MaterialUsage = getMaterialUsage($pdo);
$DefectById = getDefectById($pdo, $_GET);

function dashboardIndex(PDO $pdo): void
{
    $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $limit  = 10;
    $offset = ($page - 1) * $limit;

    $data       = getFilteredPoints($pdo, $search, $limit, $offset);
    $totalRows  = getTotalFilteredPoints($pdo, $search);
    $totalPages = (int) ceil($totalRows / $limit);

    $StatsPoints   = getStatsPoints($pdo);
    $OpenDefens    = getOpenDefects($pdo);
    $MaterialUsage = getMaterialUsage($pdo);

    require  'views/index.view.php';
}