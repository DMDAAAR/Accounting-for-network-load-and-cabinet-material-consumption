<?php
require 'connectBD.php';
require '/models/models.php';
$StatsPointsById = getStatsPointById($pdo, $_GET);
include 'index.php';
