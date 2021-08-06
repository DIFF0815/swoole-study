<?php


class Server{

    public function run(){

        //创建Server对象，监听 127.0.0.1:9501 端口
        $server = new Swoole\Server('127.0.0.1', 9501);

        //监听连接进入事件
        $server->on('Connect', function ($server, $fd) {
            echo "fd:{$fd}, Client: Connect.\n";
        });

        //监听数据接收事件
        $server->on('Receive', function ($server, $fd, $reactor_id, $data) {
            $server->send($fd, "sendData: fd:{$fd}, reactor_id:{$reactor_id} ,yes {$data}");
        });

        //监听连接关闭事件
        $server->on('Close', function ($server, $fd) {
            echo "Client: Close. fd:{$fd}\n";
        });

        //启动服务器
        $server->start();

    }

}

//测试
$server = new Server();
$server->run();


