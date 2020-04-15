<?php
namespace ctrl;

use model\admin_user;
use model\admin_group;
use z\view;

class login
{
	public static function index(){
        view::display();
	}
	
	static function login(){
		$m = new admin_user;
		$result = $m->findAdmin();
		if($result['status'] == 0){
			json(array('status'=> 0,'info'=>'帐户被禁用'));
		}
        if($result){
			//session_start();
			$d = new admin_group;
			$find = $result['gid'];
			$groupinfo = $d->findGroup($find);
			$adminUserInfo = array(
				'userid' => $result['id'],
				'username' => $result['username'],
				'gid' => $result['gid'],
				'nickname' => $result['nickname'],
				'groupname' => $groupinfo['groupname'],
				'systemrole' => $groupinfo['systemrole'],
				'channlrole' => $groupinfo['channlrole'],
				'menurole' => $groupinfo['menurole'],
				'logintime' => date('Y-m-d H:i:s',time()),
				'loginip' => getip(),
			);
			$_SESSION["cxuu_admin"] = $adminUserInfo;
			//将登录信息写入数据库
			$loginsert = $m->loginDbInsert($result['id']);

			json(array('status'=> 1,'info'=>'登录成功!'));
        }else{
			json(array('status'=> 0,'info'=>'用户名或者密码错误！'));
        }
    }

	
	static function loginOut(){
        //session_start();
		unset($_SESSION["cxuu_admin"]);
        redirect('/admin.php'); 
    }
	
	//验证码生成函数
	//访问路径 /admin.php?c=login&a=verify
	static function verify(){
        $img = new \ext\verimg();
		$img->img();
    }
}