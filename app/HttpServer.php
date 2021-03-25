<?php

namespace App;

use Exception;
use Swoole\Runtime;
use App\Console\Log;
use App\Database\DB;
use App\Router\Route;
use Swoole\Http\Server;
use Swoole\Http\Request;
use Swoole\Http\Response;
use App\Http\Request as HttpRequest;
use App\Http\Response as HttpResponse;

class HttpServer
{
    /**
     * Server host address.
     * 
     * @var string
     */
    protected string $host;

    /**
     * Server Port.
     * 
     * @var int
     */
    protected int $port;

    /**
     * @var \Swoole\WebSocket\Server|\Swoole\Http\Server
     */
    protected $server;

    /**
     * Create Http Server.
     *
     * @param  string $host
     * @param  int $port
     * @param  mixed $mode
     * @param  mixed $sockType
     */
    public function __construct($host, $port)
    {
        Runtime::enableCoroutine();

        $this->host     = $host;
        $this->port     = $port;
        $this->server   = new Server($host, $port, SWOOLE_PROCESS);

        $this->server->set([
            'reactor_num'       => env('REACTOR_NUM'), // 2 [from .env]
            'worker_num'        => env('WORKER_NUM'), // 4 [from .env]
            'max_request'       => env('MAX_REQUEST'),
            'task_worker_num'   => 1,
            'pid_file'          => __DIR__ . '/../logs/server.pid',
            'log_file'          => __DIR__ . '/../logs/server.log',
            'log_date_format'   => true,
            'log_level'         => 0, // all the levels
            // 'daemonize'         => 1,
            'dispatch_mode'     => 3
        ]);
    }

    /**
     * Run the server.
     *
     * @return void
     */
    public function listen()
    {
        $this->onStart();

        $this->onRequest();

        $this->server->on('WorkerStart', function ($server, $workerId) {
            if ($workerId >= $server->setting['worker_num']) {
                swoole_set_process_name("taxonomy:task-worker:{$workerId}");
            } else {
                swoole_set_process_name("taxonomy:event-worker:{$workerId}");
            }

            $container = Container::getInstance();

            $container->put('db', DB::getInstance());

            require_once __DIR__ . '/../routes/routes.php';
        });

        $this->server->on('task', function($server, $taskId, $workerId, $data) {
            // 
        });

        $this->server->start();
    }

    /**
     * Handle on start server.
     *
     * @param  callable $callback
     * @return void
     */
    public function onStart(callable $callback = null)
    {
        $callback = $callback ?? function (Server $server) {
            echo "Listen to http://{$this->host}:{$this->port}\n";
        };

        $this->server->on("start", $callback);
    }

    /**
     * Get the created server.
     *
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Handle requests comming to the server.
     *
     * @param  callable $callback
     * @return void
     */
    public function onRequest(callable $callback = null)
    {
        $callback = $callback ?? function (Request $request, Response $response) {

            $request = new HttpRequest($request);

            if ($request->uri() == '/favicon.ico') {
                return $response->end();
            }

            $response = new HttpResponse($response);
            $content = $this->prepareResponse($request) ?? "Welcome to FastApi Framework";
            $response->send($content);
        };

        $this->server->on("request", $callback);
    }

    /**
     * Handle incoming requests and return response.
     *
     * @param  HttpRequest $request
     * @return mixed
     */
    public function prepareResponse(HttpRequest $request)
    {
        try {
            $route = Route::getInstance();
            $data = $route->handle($request);

            Log::requestSuccess($request->server);
        } catch (Exception $e) {
            $data = json_encode([
                'code' => $e->getCode(),
                'message' => $e->getMessage()
            ]);

            Log::requestError($request->server, $e->getCode() . ' ' . $e->getMessage());
        }

        return $data;
    }
}
