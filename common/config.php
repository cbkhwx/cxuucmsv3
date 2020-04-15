<?php
return [
    //'DEBUG'=>2,
    'VER'=>['1.0', ''],//[0]:默认版本号:没有请求版本号或找不到请求版本号对应目录的情况下使用此版本号,[1]:强制指定版本号：无视请求版本号，一律使用此版本号
    'URL_MOD'=>2, //0:queryString，1：pathInfo，2：路由
    'POWEREDBY'=>'cde',
	'MODULE'=>false,
    'SESSION'=>[
		'name'=>'TOKEN', //session 名
		'auto'=>true, //自动开启 session
		'redis'=>false,
		'host'=>'',
		'port'=>'',
		'pass'=>''
    ],
    'VIEW'=>[
		'php_tag'=>'php',
		'import_tag'=>'import',
		'template_tag'=>'template',
		'ext'=>'.html',
		'theme'=>'default',
		'prefix'=>'<{',
		'suffix'=>'}>',
		'compress'=>false
    ],
    'DB'=>[
		'dsn'=>'mysql:host=127.0.0.1;dbname=cxuuweb;port=3306',
		'db'=>'cxuuweb',
		'user'=>'root',
		'pass'=>'123456',
		'charset'=>'utf8',
		'prefix'=>'cxuu_',
		'cache_mod'=>1, //缓存模式：1:redis, 2:memcached, 默认：文件
    ],
	'REDIS'=>[
        'host'=>'127.0.0.1',
        'port'=>'6379',
        'pass'=>'',
        'db'=>1,
        'timeout'=>1,
    ],
];