<?php
require 'connectBD.php';
require 'models/models.php';
$StatsPoints = getStatsPoints($pdo);
include 'index.php';
