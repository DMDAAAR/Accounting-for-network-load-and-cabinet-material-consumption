<?php
require 'connectBD.php';
require 'models/models.php';
$getAllpoints = getAllPoints($pdo);
include 'index.php';
