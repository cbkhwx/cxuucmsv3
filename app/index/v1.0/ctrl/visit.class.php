<?php
namespace ctrl;

use model\visits;

class visit
{
    //调用访问数据并JSON输出
	public static function jsonList(){
		$db = new visits;
		$result = $db->findData();
		exit(json_encode($result));
    }
}