<?php
require '../db/connectDB.php';
require '../models/models.php';
$points = getAllPoints($pdo);
include '../views/inventory.view.php';
