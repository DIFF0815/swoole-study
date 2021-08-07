<?php

class HttpServer{

    public function run(){

        $http = new Swoole\Http\Server('0.0.0.0', 9501);

        $http->set(
            [
                'enable_static_handler' => true,
                'document_root' => "/www/php72/swoole-study/data",
            ]
        );

        $http->on('Request', function ($request, $response) {
            $response->header('Content-Type', 'text/html; charset=utf-8');
            $response->end('<h1>Hello Swoole. #' . rand(1000, 9999) . '</h1>');
        });

        $http->start();

    }

}

$http = new HttpServer();
$http->run();

