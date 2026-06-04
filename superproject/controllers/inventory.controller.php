<?php
require_once '../db/connectdb.php';
require_once '../models/inventory.model.php';

$points    = getStatsPoints($pdo);
$materials = getMaterialUsage($pdo);

require '../views/inventory.view.php';