<?php

use App\App;

define('APP_BASE_PATH', __DIR__ . '/..');

require_once APP_BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(APP_BASE_PATH);
$dotenv->load();

if (!function_exists('env')) {
    /**
     * Global env variables.
     *
     * @param  string $key
     * @return mixed
     */
    function env($key)
    {
        return $_ENV[$key];
    }
}

$app = new App(env('APP_HOST'), env('APP_PORT'));
$app->init();

return $app;
