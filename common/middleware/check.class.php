<?php
//判断是否登录中间件
namespace middleware;
class check{
	public function check(){
		//session_start();
		if(!isset($_SESSION['cxuu_admin']) && !strpos(ROUTE['ctrl'],'login')){
			redirect('/admin.php?c=login'); 
		}
	}
}