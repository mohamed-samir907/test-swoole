<?php

namespace App;

use App\HttpServer;

class App
{
    /**
     * Server host address.
     * 
     * @var string
     */
    private string $host;

    /**
     * Server Port.
     * 
     * @var int
     */
    private int $port;

    /**
     * Used Server.
     * 
     * @var HttpServer
     */
    private HttpServer $server;

    /**
     * Create application instance.
     *
     * @param  string $host
     * @param  integer $port
     */
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Initialize the http server connection.
     *
     * @return void
     */
    public function init()
    {
        $this->server = new HttpServer($this->host, $this->port);

        return $this->server;
    }

    /**
     * Run the server.
     *
     * @param  callable $callback
     * @return void
     */
    public function listen(callable $callback = null)
    {
        $this->server->listen($callback);
    }
}
