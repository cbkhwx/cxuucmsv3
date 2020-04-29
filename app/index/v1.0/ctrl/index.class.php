<?php
namespace ctrl;

use z\view;

class index
{
	static function init(){
		\model\visits::insertData();//用户访问记录 写入记数
	}
	
    public static function index()
    {
		/*$html = view::GetCache(6000, 'index.html');
		if($html){
			echo $html;
		}else{
			view::Display();  //第二个参数true缓存页面
		}*/
		view::Display();
    }
}
