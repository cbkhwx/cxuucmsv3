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
		view::Display('',60);
/* 		view::Display('', 60);  //参数2：缓存时间（秒）
    view::Display('', 60, true);  //参数3：url参数不同生成不同的缓存页面
    view::Display('', 60, ['p']);  //参数3：生成缓存页面所用的url有效参数
    // 参数3 通常用来做列表页的缓存，根据分页参数不同生成相应的缓存页面
    // 使用参数3 最好限制一下有效参数，并且事先判断一下取值范围
    // 因为搜索引擎或是一些蜘蛛可能会尝试不同的url参数抓取页面，
    // 会造成无故生成大量的缓存页面 */
    }
}
