<?php
namespace ctrl;

use \middleware\adminrole;
use model\notices;
use model\admin_menu;
use z\view;

class index
{
	static function init(){
		$check = new \middleware\check();
		$check->check();
	}
			
    public static function index()
    {
		adminrole::auth();//判断用户权限
		$m = new admin_menu;
		$topMenu = $m->selectData();
		view::assign('topMenu',$topMenu);
		view::display();
    }
	
	
	public static function home()
    {	
		adminrole::auth();//判断用户权限
		$m = new notices;
		$noticeList = $m->selectData(5);
		view::assign('noticeList',$noticeList);
		view::display();
    }
}
