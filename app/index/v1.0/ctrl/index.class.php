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
		$html = view::GetCache(600, 'index.html');
		if($html){
			echo $html;
		}else{
			view::Display('', true);  //第二个参数true缓存页面
		}
		//view::Display();
    }
}
