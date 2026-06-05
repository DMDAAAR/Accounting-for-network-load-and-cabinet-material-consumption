<?php
define('APP_LOADED', true);
if (!defined('BASE_URL')) {
    define('BASE_URL', '/superproject/');
}
session_start();

$_SESSION = array();
session_destroy();

header('Location: login.controller.php');
exit();
?>