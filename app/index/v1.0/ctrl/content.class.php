<?php
namespace ctrl;

use root\base\ctrl;
use model\article;
use model\common;
use z\view;

class content extends ctrl
{
    public static function index()
    {
 		if(!isset($_GET['id']) & empty($_GET['id']) & empty(ROUTE['params']['id'])){
			return  parent::_404();
		}

		$d = new article;
		$info = $d->findData();
		
 		if(!$info || $info['status'] != 1){
			return  parent::_404();
		}
		
		$m = new common;
		$info['groupname'] = $m->findAdminGroupData($info['gid']);
		$info['nickname'] = $m->findAdminUserData($info['uid']);

		$d->hitsData(); //浏览+1
		
		view::assign('info',$info);
		view::assign('cid',$info['cid']);//用于判断栏目路径
		view::display();
    }
}
