<?php
namespace ctrl;

use root\base\ctrl;
use z\view;

class index extends ctrl
{
	public static function _404()
    {
		return  parent::_404();
    }
	
    public static function index()
    {
    $html = view::GetCache(600000, 'index.html'); // 无视url参数

    /* $html = view::GetCache(60, 'index.html', ['p']); // p 参数不同生成不同的缓存页面
    $html = view::GetCache(60, 'index.html', true); // url参数不同生成不同的缓存页面 */

    if($html){
        echo $html;
    } else {
        view::Display();
    }
		
    }
}
