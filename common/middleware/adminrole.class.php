<?php
//判断权限中间件
namespace middleware;
class adminrole{
	static public function auth(){
		$controler = ROUTE['ctrl'];
		$action = ROUTE['act'];
		if (sessionInfo('gid') != 1) {
			$basepurview = unserialize(sessionInfo('systemrole'));
			$contrAndAction = strtolower($controler . "_" . $action); //转换成小写
			$basepurview = array_map('strtolower', $basepurview);//转换成小写
			//P($basepurview);
			if (!in_array($contrAndAction, $basepurview)) {
				//echo "no";
				echo "<script> alert('你无权限操作此模块！');</script>";
			   exit;
			}
		}
	}
}