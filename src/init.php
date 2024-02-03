<?php

session_start();

require_once '../vendor/autoload.php';
require_once '../config/config.php';


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,1));
$dotenv->safeLoad();
Routes\Routes::index();