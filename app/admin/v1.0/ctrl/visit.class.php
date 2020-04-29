<?php
namespace ctrl;

use \middleware\adminrole;
use model\visits;
use z\view;

class visit
{
	static function init(){
			$check = new \middleware\check();
			$check->check();
		}
		
	public static function index(){
		adminrole::auth();//判断用户权限
		$d = new visits;
		$visits = $d->selectData();
		view::assign('visits',$visits);
        view::display();
	}
}