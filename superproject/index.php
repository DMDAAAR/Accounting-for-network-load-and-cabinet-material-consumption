<?php
require_once 'db/connectDB.php';            // файл лежит рядом
require_once 'controllers/DashboardController.php';
dashboardIndex($pdo);

$StatsPoints = getStatsPoints($pdo);

$StatsPointsById = getStatsPointById($pdo, $_GET);

$RoomById = getRoomById($pdo, $_GET);

$OpenDefens = getOpenDefects($pdo);

$MaterialUsage = getMaterialUsage($pdo);

$DefectById = getDefectById($pdo, $_GET);
