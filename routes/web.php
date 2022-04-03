<?php

$router->get('/', function () {
    view('index');
});

$router->get('docs-pmint', function () {
    view('docs-pmint/index');
});

include 'api.php';

// $router->get('update-pmint', [Controllers\UpdatePmint::class, 'download_pmint']);