<?php
//session_id(\Ifmo\Web\Core\Utils::getRandom());
session_start();
require_once __DIR__ . '/../vendor/autoload.php';

$request = new \Ifmo\Web\Core\Request();

$config = __DIR__ . '/../config.json';

$app = new \Ifmo\Web\Core\Application($config);
$response = $app->handleRequest($request);
$response->send();

