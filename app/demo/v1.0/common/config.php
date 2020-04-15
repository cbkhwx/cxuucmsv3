<?php
return [
    'DEBUG' => 2,
    'MODULE' => false,
    'VER' => ['1.0', ''], //[0]:默认版本号:没有请求版本号或找不到请求版本号对应目录的情况下使用此版本号,[1]:强制指定版本号：无视请求版本号，一律使用此版本号
    'URL_MOD' => 2, //0:queryString，1：pathInfo，2：路由
];
