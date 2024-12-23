<?php

$routes = [
    'jwt-and-mfp-auth' => include 'api/jwtAndMfpAuthRoutes.php',
    'only-mfp-auth' => include 'api/onlyMfpAuthRoutes.php',
    'no-auth' => include 'api/noAuthRoutes.php',
];

foreach ($routes as $route) {
    $route();
}
