<?php
namespace ctrl;

use \middleware\adminrole;
use model\admin_user;
use model\admin_group;
use z\view;
class admingroup
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
		$d = new admin_group;
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
		if(!isset($_POST['groupname'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		//验证用户组名是否存在
		$m = new admin_group;
		$check = $m->checkNameData();
		if($check){
			json(array('status'=> 0,'info'=>'用户组名已经存在！'));
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
			$info = $m->findData();
			view::assign('info',$info);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function edit(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['groupname'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		//验证用户组名是否存在
		$m = new admin_group;
		$check = $m->checkNameData();
		if($check){
			json(array('status'=> 0,'info'=>'用户组名已经存在！'));
		}
		
		$m = new admin_group;
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
			if($_POST['id']==1){
				json(array('status'=> 0,'info'=>'不能删除超级管理员组！'));
			}
			$m = new admin_group;
			$del = $m->deleteOneData();
			if($del){
				json(array('status'=> 1,'info'=>'删除成功'));
			}
		}else{
			json(array('status'=> 0,'info'=>'ID错误！'));
		}
	}
	
	//系统权限设置
	public static function systemrole(){
		adminrole::auth();//判断用户权限
		if(isset($_GET['id'])){
			$m = new admin_group;
			$info = $m->findData();
			$systemrole = unserialize($info['systemrole']);
			view::assign('systemrole',$systemrole);
			view::assign('info',$info);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function systemroleedit(){
		adminrole::auth();
		if(!isset($_POST['id'])){
			json(array('status'=> 0,'info'=>'编辑ID错误！'));
		}
		$m = new admin_group;
		$result = $m->updateSystemroleData();
		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	//系统栏目设置
	public static function channlrole(){
		adminrole::auth();
		if(isset($_GET['id'])){
			$m = new admin_group;
			$info = $m->findData();
			$channlrole = unserialize($info['channlrole']);
			$channlid = implode(",",$channlrole);
			view::assign('channlid',$channlid);
			view::assign('info',$info);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function channlroleedit(){
		adminrole::auth();
		if(!isset($_POST['id'])){
			json(array('status'=> 0,'info'=>'编辑ID错误！'));
		}
		$m = new admin_group;
		$result = $m->updateChannlroleData();
		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	//系统菜单设置
	public static function menurole(){
		adminrole::auth();
		if(isset($_GET['id'])){
			$m = new admin_group;
			$info = $m->findData();
			$menurole = unserialize($info['menurole']);
			$menuid = implode(",",$menurole);
			view::assign('menuid',$menuid);
			view::assign('info',$info);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function menuroleedit(){
		adminrole::auth();
		if(!isset($_POST['id'])){
			json(array('status'=> 0,'info'=>'编辑ID错误！'));
		}
		$m = new admin_group;
		$result = $m->updateMenuroleData();
		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
}