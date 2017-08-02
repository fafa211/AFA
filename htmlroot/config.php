<?php
$config = array();

//主域名设置
$config['domain'] = "http://www.afa.com/";

//后缀，静态化使用,只能是 .html, .shtml, .php等常用脚本后缀，否则很容易出问题
$config['suffix'] = '.html';

//session配置
$config['session'] = array(
    'native'=>array(
        'name'=>'ssid',
        'lifetime'=>3600,
        'encrypted'=>false,
    )
);

//分页设置
$config['page'] = array(
    'psize' => 10, // 每页显示的记录数
    'pnum' => 5 // 页码偏移量
);

//上传设置
$config['upload'] = array(
    'direct' => DOCROOT.DIRECTORY_SEPARATOR.'upload',
    'size' => 2097152,
    'domain'=>"http://f1.afacms.com/"
);

//加解密秘钥
$config['authkey'] = 'sj323TY#@w1&$qw21';

//数据库设置, 支持多数据库, 支持主从
$config['database'] = array(
    'default' => array(//默认数据库
        // 数据库设置
        'master' => array( // 数据库链接设置 Master
            'host' => 'localhost', // 数据库主机名或IP
            'user' => 'myservice', // 用户名
            'password' => 'myserver321', // 密码
            'dbname' => 'myservices', // 数据库名称
            'charset' => 'utf8', // 字符集
            'conmode' => false
        ),
    ),
    'logServer' => array(//默认数据库
        // 数据库设置
        'master' => array( // 数据库链接设置 Master
            'host' => 'localhost', // 数据库主机名或IP
            'user' => 'myservice', // 用户名
            'password' => 'myserver321', // 密码
            'dbname' => 'myserver_common_logs', // 数据库名称
            'charset' => 'utf8', // 字符集
            'conmode' => false
        ),
    ),




);// true为长久连接模式，false为短暂连接模式

$config['email'] = array(
    'driver'=>'smtp',       //验证方式
    'options'=>array(
        'hostname'=>'smtp.exmail.qq.com',     //邮件SMTP服务器地址
        'username'=>'zhengsf@kingsum.com.cn',     //邮件帐号
        'password'=>'Faaaaaa123',     //密码
        //'encryption'=>'',   //加密方式
        'from'=>'zhengsf@kingsum.com.cn',         //显示的发送邮件帐号
        'port'=>25,         //邮件服务器端口号
        'timeout'=>10,
        //'auth'=>''
    )
);
