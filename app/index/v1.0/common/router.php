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
    '*' => [ // 以上匹配不到时使用此路由
        'ctrl' => 'index',
        'act' => 'index',
    ],
];
