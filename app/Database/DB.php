<?php

namespace App\Database;

use PDO;
use App\Support\Singleton;
use Swoole\Database\PDOPool;
use Swoole\Database\PDOConfig;

class DB
{
    use Singleton;

    /**
     * PDOPool Instance.
     * 
     * @var PDOPool
     */
    private PDOPool $pool;

    /**
     * PDO Configs.
     * 
     * @var array
     */
    private array $config = [];

    /**
     * @var array
     */
    private array $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    /**
     * Constructor.
     */
    private function __construct()
    {
        $config = require APP_BASE_PATH . '/config/config.php';
        $this->config = $config['db'];

        $pdoConfig = (new PDOConfig())
            ->withHost($this->config['host'])
            ->withPort(3306)
            ->withDbName($this->config['database'])
            ->withCharset('utf8mb4')
            ->withUsername($this->config['username'])
            ->withPassword($this->config['password'])
            ->withOptions($this->options);

        $this->pool = new PDOPool($pdoConfig);
    }

    /**
     * Get PDO Pool
     *
     * @return PDOPool
     */
    public function pool()
    {
        return $this->pool;
    }
}
