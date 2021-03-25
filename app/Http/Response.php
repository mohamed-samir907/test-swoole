<?php

namespace App\Http;

use Swoole\Http\Response as SwooleResponse;

class Response
{
    /**
     * Swoole Http Response.
     * 
     * @var SwooleResponse
     */
    private SwooleResponse $response;

    /**
     * Constructor.
     *
     * @param SwooleResponse $response
     */
    public function __construct(SwooleResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Prepare and send the response.
     *
     * @param  mixed $content
     * @return mixed
     */
    public function send($content)
    {
        $this->response->header('Content-Type', 'application/json; charset=utf-8');
        // $this->response->header('Content-Type', 'text/html; charset=utf-8');
        $this->response->write($content);
    }
}