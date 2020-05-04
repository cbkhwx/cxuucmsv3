<?php
namespace ctrl;

use \middleware\adminrole;
use z\view;
class cache
{
	static function init(){
			$check = new \middleware\check();
			$check->check();
		}
		
	/*
	缓存管理
	*/
	public static function index(){
		adminrole::auth();//判断用户权限
		//当前启用的缓存类型
		//文件缓存赋值
		$dirsize = array();
		$dirsize['htmlCaheDir'] = P_HTML;
		$dirsize['htmlCahe'] = file_size_format(@dirSize($dirsize['htmlCaheDir']));
		$dirsize['fileCaheDir'] = P_CACHE;
		$dirsize['fileCahe'] = file_size_format(@dirSize($dirsize['fileCaheDir']));
		$dirsize['fileHomeCaheDir'] = P_RUN.'index/';
		$dirsize['fileHomeCahe'] = file_size_format(@dirSize($dirsize['fileHomeCaheDir']));
		$dirsize['fileAdminCaheDir'] = P_RUN.'admin/';
		$dirsize['fileAdminCahe'] = file_size_format(@dirSize($dirsize['fileAdminCaheDir']));
		$dirsize['phpErLogCaheDir'] = P_RUN.'php_error_log/';
		$dirsize['phpErLogCahe'] = file_size_format(@dirSize($dirsize['phpErLogCaheDir']));
		view::assign('dirsize',$dirsize);
        view::display();
	}
	
	//清除所有Redis缓存
	static function delRedisCache(){
		adminrole::auth();//判断用户权限
        $result = RCD();
        if($result){
			json(array('status'=> 1,'info'=>'清除Redis缓存成功'));
        }else{
			json(array('status'=> 0,'info'=>'清除Redis缓存失败！'));
        }
    }
	
	//清除文件缓存
	static function delFileCache(){
		adminrole::auth();//判断用户权限
		$id = $_GET['id'];
		switch($id){
			case 1:
				del_dir(P_CACHE,1);
				json(array('status'=> 1,'info'=>'清除 内容文件缓存 成功'));
			break;
			case 2:
				del_dir(P_RUN.'/admin',1);
				json(array('status'=> 1,'info'=>'清除 后台程序缓存 成功'));
			break;
			case 3:
				del_dir(P_HTML,1);
				json(array('status'=> 1,'info'=>'清除 HTML缓存 成功'));
			break;
			case 4:
				del_dir(P_RUN.'/index',1);
				json(array('status'=> 1,'info'=>'清除 前台程序缓存 成功'));
			break;
		} 
    }
}