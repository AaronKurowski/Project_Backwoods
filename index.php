<?php

require __DIR__ . "/Includes/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if((isset($uri[3]) && $uri[3] != 'user') || !isset($uri[4])) {
    header("HTTP/1.1 404 Not Found");
    exit;
}

require_once 'Controllers/UserController.php';

$objFeedController = new UserController();
$strMethodName = $uri[4];
$objFeedController->{$strMethodName}();

switch($uri[3]) {
    case 'user':
        $objFeedController = new UserController();
        $strMethodName = $uri[4];
        $objFeedController->{$strMethodName}();
}