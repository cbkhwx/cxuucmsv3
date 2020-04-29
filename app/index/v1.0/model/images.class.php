<?php
namespace model;

class images
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
        $result = $db->table('images')->where($where)->limit(6)->cache(6600)->select();
        return $result;
   }
   public static function listData()
    {
        $db = \ext\db::Init();
		$where['status'] = 1;
		$p = self::routerParams('p');
        $num = 20;  //每页显示条数
        $page = ['num' => $num, 'p' => $p, 'return' => ['prev', 'next', 'first', 'last', 'list']];
		$result['data'] = $db->table('images')->page($page)->order('id DESC')->select();
        $result['page'] = $db->getPage();
        return $result;
    }
   
   //查询数据列表
   public static function selectImageData()
   {
        $db = \ext\db::Init();
		$where['aid'] = self::routerParams('id');
        $result = $db->table('images_image')->where($where)->cache(6600)->select();
        return $result;
   }

}
