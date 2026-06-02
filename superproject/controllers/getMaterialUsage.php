<?php
require 'connectBD.php';
require 'models/models.php';
$OpenDefens = getMaterialUsage($pdo);
include 'index.php';
