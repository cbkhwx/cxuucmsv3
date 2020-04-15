<?php
namespace ctrl;

use \middleware\adminrole;
use model\notices;
use z\view;

class notice
{
	static function init(){
			$check = new \middleware\check();
			$check->check();
		}
		
	public static function index(){
		adminrole::auth();//判断用户权限
        view::display();
	}
	
	public static function jsonlist(){
		adminrole::auth();//判断用户权限
		$d = new notices;
		$result = $d->jsonPageSelect();			
		$jsonlist = array();
		$jsonlist['code'] = 0;
		$jsonlist['msg'] = 'ok';
		$jsonlist['count'] = $result['page']['rows'];
		$jsonlist['data'] = $result['data'];
		exit(json_encode($jsonlist));
	}
	
	public static function addview(){
		adminrole::auth();//判断用户权限
        view::display();
	}
	
	public static function add(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['title'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		$m = new notices;
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
			$m = new notices;
			$notice = $m->findData();
			view::assign('notice',$notice);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function edit(){
		adminrole::auth();
		if(!isset($_POST['title'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		$m = new notices;
		$result = $m->updateData();
		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	public static function switchStatus(){
		adminrole::auth();
		if(isset($_POST['id'])){
			$m = new notices;			
			$edit = $m->switchStatus();
			if($edit){
				json(array('status'=> 1,'info'=>'设置成功'));
			}
		}else{
			json(array('status'=> 0,'info'=>'ID错误！'));
		}
	}
	
	public static function del(){
		adminrole::auth();
		if(isset($_POST['id'])){
			$m = new notices;
			$del = $m->deleteOneData();
			if($del){
				json(array('status'=> 1,'info'=>'删除成功'));
			}
		}else{
			json(array('status'=> 0,'info'=>'ID错误！'));
		}
	}

}