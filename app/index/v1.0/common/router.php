<?php
return [
    'PATH' => '', //此处是url的根路径，前后不带"/"，index可省略留空
    '/' => [
        'ctrl' => 'index',
        'act' => 'index',
    ],
    '/info' => [
        'ctrl' => 'content',
        'act' => 'index',
		'params'=>['id']
    ],
	'/list' => [
        'ctrl' => 'contents',
        'act' => 'index',
		'params'=>['cid','p']
    ],
    '/visit' => [
        'ctrl' => 'visit',
        'act' => 'jsonList',
		//'params'=>['cid','p']
    ],
	'/image' => [
        'ctrl' => 'image',
        'act' => 'index',
		'params'=>['id']
    ],
	'/images' => [
        'ctrl' => 'imagelist',
        'act' => 'index',
		'params'=>['p']
    ],
	'/member' => [
        'ctrl' => 'member',
        'act' => 'index',
    ],
    '*' => [ // 以上匹配不到时使用此路由
        'ctrl' => 'index',
        'act' => 'index',
    ],
];
