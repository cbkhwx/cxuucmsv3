<?php
namespace ctrl;

use model\article;
use z\view;

class index
{
    public static function index()
    {
		if(!isset($_GET['keywords']) || empty($_GET['keywords'])){
			echo('请输入搜索关键字！');
			exit;
		}
		$d = new article;
		$list = $d->searchJoinData();
		view::assign('list',$list['data']);
		view::assign('page',$list['page']);
		view::display();
    }
}
