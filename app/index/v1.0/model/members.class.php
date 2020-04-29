<?php
namespace model;

class members
{
	//判断获取 是否是 GET值  用于自动切换路由模式
	protected static function routerParams($val){
		if(!empty(ROUTE['query'][$val])){
			$params = ROUTE['query'][$val];
		}else{
			$params = $_GET[$val];
		}
		return $params;
	}
	
   //查询数据列表
   public static function selectData()
   {
        $db = \ext\db::Init();
		$where['status'] = 1;
        $result = $db->table('member')->where($where)->cache(6600)->order('sort asc')->select();
        return $result;
   }


}
