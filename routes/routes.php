<?php

use App\Container;
use App\Database\DB;
use App\Router\Route;
use App\Services\TaxonomyService;

$route = Route::getInstance();

/** @var TaxonomyService */
$tnt = TaxonomyService::getInstance([
    'host' => env('DB_HOST'),
    'database' => env('DB_DATABASE'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'storage' => __DIR__ . '/../db/'
]);

$route->get('/', function () {
    return 'Welcome to My Service';
});

$route->get('/search/{query}', function($query) use ($tnt) {
    $container = Container::getInstance();
    $db = $container->get('db');

    $items = $tnt->search($query, $db);
    return json_encode($items);
});
