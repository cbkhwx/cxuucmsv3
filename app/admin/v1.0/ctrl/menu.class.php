<?php
namespace ctrl;

use model\admin_menu;
use z\view;

class menu
{
	//私有静态方法查询数据表
	private static function selectData()
    {
		$d = new admin_menu;
		$list = $d->selectSecendData();
		return $list;
    }
	
    public static function index()
    {
		view::assign('list',self::selectData());
        view::display();
    }
	
	public static function content()
    {
		view::assign('list',self::selectData());
        view::display();
    }
	
	public static function channel()
    {
		view::assign('list',self::selectData());
        view::display();
    }
	
	public static function adminuser()
    {
		view::assign('list',self::selectData());
        view::display();
    }
	
	public static function system()
    {
		view::assign('list',self::selectData());
        view::display();
    }
}
