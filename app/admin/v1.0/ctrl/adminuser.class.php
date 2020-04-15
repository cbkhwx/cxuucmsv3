<?php
namespace ctrl;

use \middleware\adminrole;
use model\admin_user;
use model\admin_group;
use z\view;
class adminuser
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
		if (trim($_GET['limit'])) {
		 $limit = trim($_GET['limit']);
		}else{
		 $limit = 10;
		}
		$d = new admin_user;
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
		$m = new admin_group;
		$groupList = $m->selectGroup();
		view::assign('groupList',$groupList);
        view::display();
	}
	
	public static function add(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['username'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		//验证用户名是否存在
		$m = new admin_user;
		$check = $m->checkNameData();
		if($check){
			json(array('status'=> 0,'info'=>'用户名已经存在！'));
		}
		
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
			$m = new admin_group;
			$groupList = $m->selectGroup();
			$u = new admin_user;
			$info = $u->findData();
			view::assign('groupList',$groupList);
			view::assign('info',$info);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function edit(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['username'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		
		//验证用户名是否存在
		$m = new admin_user;
		$check = $m->checkNameData();
		if($check){
			json(array('status'=> 0,'info'=>'用户名已经存在！'));
		}
		$result = $m->updateData();
		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	public static function switchStatus(){
		adminrole::auth();//判断用户权限
		if(isset($_POST['id'])){
			$m = new admin_user;			
			$edit = $m->switchStatus();
			if($edit){
				json(array('status'=> 1,'info'=>'设置成功'));
			}
		}else{
			json(array('status'=> 0,'info'=>'ID错误！'));
		}
	}
	
	public static function del(){
		adminrole::auth();//判断用户权限
		if(isset($_POST['id'])){
			$m = new admin_user;
			$del = $m->deleteOneData();
			if($del){
				json(array('status'=> 1,'info'=>'删除成功'));
			}
		}else{
			json(array('status'=> 0,'info'=>'ID错误！'));
		}
	}
	
	public static function rewritepassword(){
		adminrole::auth();//判断用户权限
		if(isset($_GET['id'])){
			$u = new admin_user;
			$info = $u->findData();
			view::assign('info',$info);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function passwordedit(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['nickname'])){
			json(array('status'=> 0,'info'=>'请填写昵称！'));
		}
		$m = new admin_user;
		$result = $m->passwordEdit();
		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}

}