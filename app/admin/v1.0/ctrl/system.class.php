<?php
namespace ctrl;

use \middleware\adminrole;
use model\siteconfig;
use z\view;

class system
{
	static function init(){
			$check = new \middleware\check();
			$check->check();
		}
	public static function index(){
		adminrole::auth();//判断用户权限
		$m = new siteconfig;
		$config = $m->FindData();
		view::assign('config',$config);
        view::display();
	}
	
	public static function edit(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['sitename'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		$m = new siteconfig;
		$result = $m->updateData();
		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
}