<?php

$http = new swoole_http_server("127.0.0.1", 9501);


#配置项详情查看:http://wiki.swoole.com/wiki/page/13.html
$http->set(array(
    'reactor_num'=>2, //reactor thread num : reactor线程数量
    'worker_num'=>2,            //创建8个worker进程
    'daemonize' => false,        //是否为守护进程
    'dispatch_mode' => 2,       //固定模式，根据连接的文件描述符分配worker。这样可以保证同一个连接发来的数据只会被同一个worker处理
    'task_worker_num' => 4,     #创建4个task进程
    'open_tcp_nodelay' => true, #tcp无延迟
    'max_conn'=>128,            #此参数用来设置Server最大允许维持多少个tcp连接,详情:http://wiki.swoole.com/wiki/page/282.html
    'max_request' => 1000,      #此参数表示worker进程在处理完n次请求后结束运行
    'backlog' => 128,           #此参数将决定最多同时有多少个待accept的连接
    'open_cpu_affinity' => 1,   #启用CPU亲和设置
    'heartbeat_check_interval'=> 60, #心跳检测机制:每隔多少秒检测一次，单位秒，Swoole会轮询所有TCP连接，将超过心跳时间的连接关闭掉
    'heartbeat_idle_time'=> 120,     #TCP连接的最大闲置时间，单位s , 如果某fd最后一次发包距离现在的时间超过heartbeat_idle_time会把这个连接关闭
    'log_file' => '/tmp/swoole_http_server.log',    //log日志文件
    'upload_tmp_dir'=>"../runtime/tempfile/",       //上传文件临时存储地址
));



$http->on('request', function ($request, $response) use ($http) {

    $_GET = isset($request->get)?$request->get:array();
    $_POST = isset($request->post)?$request->post:array();
    $_COOKIE = isset($request->cookie)?$request->cookie:array();
    $_FILES = isset($request->files)?$request->files:array();

    $_SERVER = array();
    foreach($request->server as $k=>$v) {
        $_SERVER[strtoupper($k)] = $v;
    }

    require_once "index_swoole.php";

    if(is_file(DOCROOT.$request->server['path_info'])){
        return $response->end(file_get_contents(DOCROOT.$request->server['path_info']));
    }

    //执行请求
    $currentRequest = Request::instance($request->server['path_info']);
    $currentRequest->request = $request;
    $currentRequest->response = $response;

    $currentRequest->run();

    //启动 task 任务
    $http->task($currentRequest->controller);

    //输出性能调试信息
    F::debug($currentRequest);
});

$http->on('task', function($serv, $task_id, $from_id, $data){
    echo $task_id."\n";
    echo $from_id."\n";
    echo $data."\n";
    //var_dump( $serv);

    return 'myController is: '.$data;
});

$http->on('finish', function($serv, $task_id, $data){
    echo "Task {$task_id} finish\n";
    echo "Result: {$data}\n";
});

$http->on('close', function($serv, $fd, $from_id){
    echo $fd . ' is closed'.PHP_EOL;
});

$http->start();