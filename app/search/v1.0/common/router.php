<?php
return [
    'PATH' => 'search', //此处是url的根路径，前后不带"/"，index可省略留空
    '/' => [
        'ctrl' => 'index',
        'act' => 'index',
		'params'=>['keywords']
    ],

    '*' => [ // 以上匹配不到时使用此路由
        'ctrl' => 'index',
        'act' => 'index',
    ],
];
