<?php
define('APP_LOADED', true);

session_start();

$_SESSION = array();
session_destroy();

header('Location: login.controller.php');
exit();
?>