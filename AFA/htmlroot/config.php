<?php
$config = array(
    //数据库设置
    'master' => array( // 数据库链接设置 Master
        'host' => '127.0.0.1', // 数据库主机名或IP
        'user' => 'root', // 用户名
        'password' => 'tl123456', // 密码
        'dbname' => 'afadbs', // 数据库名称
        'charset' => 'utf8', // 字符集
        'conmode' => false
    ) // true为长久连接模式，false为短暂连接模式
,
    
//     'slave' => array( // 数据库链接设置 Slave
//         'host' => '192.168.1.62', // 数据库主机名或IP
//         'user' => 'root', // 用户名
//         'password' => '123456', // 密码
//         'dbname' => 'afadbs', // 数据库名称
//         'charset' => 'utf8', // 字符集
//         'conmode' => false  // true为长久连接模式，false为短暂连接模式
//     ),

    //上传设置
    'upload' => array(
        'direct' => 'upload',
        'size' => 2097152
    ) // 2M
,
    //分页设置
    'page' => array(
        'psize' => 10, // 每页显示的记录数
        'pnum' => 5
    ) // 页码偏移量
,
    //缓存设置
    'cache' => array(
        'driver' => 'file',
        'cache_dir' => APPPATH . 'cache',
        'default_expire' => 3600,
        'ignore_on_delete' => array(
            '.gitignore',
            '.git',
            '.svn'
        )
    )
)
;