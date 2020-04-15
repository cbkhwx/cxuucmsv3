<?php
namespace ctrl;

use model\article;
use z\view;

class search
{
    public static function index()
    {
		if(!isset($_GET['keywords'])){
			echo 'keywords为空';
		}
		$d = new article;
		$list = $d->searchJoinData();
		view::assign('list',$list['data']);
		view::assign('page',$list['page']);
		view::display();
    }
}
