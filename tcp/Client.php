<?php

class Client{

    public function run(){
        $client = new Swoole\Client(SWOOLE_SOCK_TCP);
        if (!$client->connect('192.168.31.155', 9501, -1)) {
            exit("connect failed. Error: {$client->errCode}\n");
        }
        $client->send("hello world\n");
        echo $client->recv();
        $client->close();
    }

}

//测试
$client = new Client();
$client->run();
