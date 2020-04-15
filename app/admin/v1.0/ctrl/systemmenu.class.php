<?php
namespace ctrl;

use \middleware\adminrole;
use model\admin_menu;
use z\view;

class systemmenu
{
	static function init(){
			$check = new \middleware\check();
			$check->check();
		}
		
	public static function index(){
		adminrole::auth();//判断用户权限
        view::display();
	}
	//列表显示调用
	public static function jsonlist(){
		adminrole::auth();//判断用户权限
		$d = new admin_menu;
		$result = $d->jsonPageSelect();	
		$jsonlist = array();
		$jsonlist['code'] = 1;
		$jsonlist['data'] = generateTree($result);
		exit(json_encode($jsonlist));
	}
	//列表显示 权限设置调用
	public static function menutreejsonlist(){
		adminrole::auth();//判断用户权限
		$d = new admin_menu;
		$result = $d->jsonPageSelect();	
		$jsonlist = array();
		$jsonlist['code'] = 0;
		$jsonlist['msg'] = '操作成功';
		$jsonlist['data'] = menuCateTree($result);
		exit(json_encode($jsonlist));
	}
	
	public static function addview(){
		adminrole::auth();//判断用户权限
		$d = new admin_menu;
		$list = $d->selectData();	
		view::assign('list',$list);
        view::display();
	}
	
	public static function add(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['pid'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		$data = [
			'pid' => $_POST['pid'],
			'name' => $_POST['name'],
			'controller' => $_POST['controller'],
			'url' => $_POST['url'],
			'ico' => $_POST['ico'],
			];
		$m = new admin_menu;
		$result = $m->insertData();
  		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	public static function editview(){
		adminrole::auth();//判断用户权限
		if(isset($_GET['id'])){
			$d = new admin_menu;
			$list = $d->selectData();	
			$info = $d->findData();	
			view::assign('list',$list);
			view::assign('info',$info);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function edit(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['pid'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		$m = new admin_menu;
		$result = $m->updateData();
		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	
	public static function del(){
		adminrole::auth();//判断用户权限
		if(isset($_POST['id'])){
			$m = new admin_menu;
			$del = $m->deleteOneData();
			if($del){
				json(array('status'=> 1,'info'=>'删除成功'));
			}
		}else{
			json(array('status'=> 0,'info'=>'ID错误！'));
		}
	}

}