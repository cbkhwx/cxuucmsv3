<?php
namespace ctrl;

use root\base\ctrl;
use model\article;
use model\common;
use z\view;

class contents extends ctrl
{
    public static function index()
    {
		if(!isset($_GET['cid']) & empty($_GET['cid']) & empty(ROUTE['params']['cid'])){
			return  parent::_404();
		}
		
		$d = new article;
		$list = $d->listData();
		
		if(empty($list['data'])){
			return  parent::_404();
		}
		
		$d = new common;
		$findCate = $d->findCateData($list['cid']);
		
		view::assign('list',$list['data']);
		view::assign('page',$list['page']);
		view::assign('cid',$list['cid']);
		view::assign('catename',$findCate['name']);
		if(empty($findCate['theme'])){
			view::display('',60,true);
		}else{
			view::display($findCate['theme'],60,true);
		}
		
    }
}
