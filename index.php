<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'Carne.php';
require_once 'routes.php';
require_once 'helpers.php';

$method = $_SERVER["REQUEST_METHOD"];
$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$uriSegments = explode('/', trim($uri, '/'));

handleRoutes($method, $uriSegments);
