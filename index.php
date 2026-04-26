<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "TheaterController.php";

$controller = new TheaterController(array_merge($_GET, $_POST));
$controller->run();
?>