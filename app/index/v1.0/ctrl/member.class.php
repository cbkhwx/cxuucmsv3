<?php
namespace ctrl;
use root\base\ctrl;
use model\members;
use z\view;

class member extends ctrl
{
	static function init(){
		\model\visits::insertData();//用户访问记录 写入记数
	}
	
    public static function index()
    {
/*  		if(!isset($_GET['id']) & empty($_GET['id']) & empty(ROUTE['params']['id'])){
			return  parent::_404();
		} */
		
		$d = new members;
		$list = $d->selectData();
		view::assign('list',$list);
		view::Display();
    }
}
