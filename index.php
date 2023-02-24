<?php

use src\Tools\RequestTools;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Router/Router.php';

$router = new Router();
$router->run(RequestTools::inputServer('REQUEST_URI'));