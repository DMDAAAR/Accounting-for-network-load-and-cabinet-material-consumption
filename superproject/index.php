<?php
require_once './models/inventory.models.php';

$StatsPoints = getStatsPoints($pdo);

$StatsPointsById = getStatsPointById($pdo, $_GET);

$RoomById = getRoomById($pdo, $_GET);

$OpenDefens = getOpenDefects($pdo);

$MaterialUsage = getMaterialUsage($pdo);

$DefectById = getDefectById($pdo, $_GET);
