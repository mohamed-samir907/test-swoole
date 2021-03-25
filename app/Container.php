<?php

namespace App;

use App\Support\Singleton;

class Container
{
    use Singleton;

    private function __construct() {}

    private array $services = [];

    public function put($key, $value)
    {
        $this->services[$key] = $value;
    }

    public function get($key)
    {
        return $this->services[$key];
    }
}
