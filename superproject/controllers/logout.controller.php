<?php
//защита от прямого вызова
define('APP_LOADED', true);

session_start();
//очистка сессии
$_SESSION = array();
//удаление сессии
session_destroy();
//переход на страницу входа
header('Location: login.controller.php');
exit();
?> 