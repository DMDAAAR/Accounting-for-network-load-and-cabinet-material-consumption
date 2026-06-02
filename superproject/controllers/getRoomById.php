<?php
require 'connectBD.php';
require 'models/models.php';
$OpenDefens = getRoomById($pdo, $_GET);
include 'index.php';
