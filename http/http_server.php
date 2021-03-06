<?php
/**
 * Created by PhpStorm.
 * User: baidu
 * Date: 18/2/28
 * Time: 上午1:39
 */


$http = new Swoole\Http\Server('0.0.0.0', 9503);

$http->set(
    [
        'enable_static_handler' => true,
        'document_root' => "/www/php72/swoole-study/thinkphp/public/static",
        'worker_num' => 5,
    ]
);
$http->on('WorkerStart', function($server,  $worker_id) {
    // 定义应用目录
    define('APP_PATH', __DIR__ . '/../thinkphp/application/');
    // 加载框架里面的文件
    //require __DIR__ . '/../thinkphp/vendor/topthink/base.php';
    //require __DIR__ . '/../thinkphp/start.php';
    require __DIR__ . '/../thinkphp/vendor/autoload.php';
});
$http->on('request', function($request, $response) use($http){

    //define('APP_PATH', __DIR__ . '/../application/');
    //require __DIR__ . '/../thinkphp/base.php';
    $_SERVER  =  [];
    if(isset($request->server)) {
        foreach($request->server as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if(isset($request->header)) {
        foreach($request->header as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }

    $_GET = [];
    if(isset($request->get)) {
        foreach($request->get as $k => $v) {
            $_GET[$k] = $v;
        }
    }
    $_POST = [];
    if(isset($request->post)) {
        foreach($request->post as $k => $v) {
            $_POST[$k] = $v;
        }
    }
    
    ob_start();
    // 执行应用并响应
    try {
        $h = (new think\App())->http;

        $res = $h->run();

        $res->send();

        $h->end($res);
    }catch (\Exception $e) {
        // todo
        //echo "-action-".request()->action().PHP_EOL;
        var_dump($e->getMessage());
    }

    //echo "-action-".request()->action().PHP_EOL;
    $res = ob_get_contents();

    ob_end_clean();
    //var_dump($res);
    $response->end($res);
    //$http->close();
});

$http->start();

// topthink/think-swoole