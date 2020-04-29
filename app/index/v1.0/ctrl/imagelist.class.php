<?php
namespace ctrl;
use root\base\ctrl;
use model\images;
use model\common;
use z\view;

class imagelist extends ctrl
{
	static function init(){
		\model\visits::insertData();//用户访问记录 写入记数
	}
	
    public static function index()
    {
/*  		if(!isset($_GET['id']) & empty($_GET['id']) & empty(ROUTE['params']['id'])){
			return  parent::_404();
		} */
		
		$d = new images;
		$list = $d->listData();
		view::assign('list',$list['data']);
		view::assign('page',$list['page']);
		view::Display();
    }
}
