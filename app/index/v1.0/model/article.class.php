<?php
namespace model;

class article
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
	//关联查找一条数据，个人觉得多个表关联查询会影响效率，改为控制器读取较固定的表缓存实现
    public static function findData()
    {
        $db = \ext\db::Init();
		$where['a.id'] = self::routerParams('id');
		//$field = 'b.content,m.atturl,m.priname,a.attid,a.id,a.title,a.examine,a.hits,a.status,a.time,a.uid,a.gid,a.cid';
		//$field = 'c.id as cateid , c.name as catename,b.content,g.groupname,u.nickname,m.atturl,m.priname,a.attid,a.id,a.title,a.examine,a.hits,a.status,a.time';
		//$join[] = 'LEFT JOIN article_cate c ON a.cid=c.id';
		//$join[] = 'LEFT JOIN admin_user u ON a.uid=u.id';
		//$join[] = 'LEFT JOIN admin_group g ON u.gid=g.id';
		$join[] = 'LEFT JOIN article_content b ON a.id=b.aid';
		$join[] = 'LEFT JOIN attments m ON a.attid=m.attid';
        $result = $db->table('article a')->Join($join)->where($where)->find();
        return $result;
    }
	//更新浏览次数据  +1
    public function hitsData()
    {
        $db = \ext\db::Init();
        $where['id'] = self::routerParams('id');
		$save = ['hits'=>'{{hits + 1}}']; // hits字段值增加1
        $result = $db->table('article')->where($where)->Update($save);
        return $result;
    }
	
	//查询 GET值 栏目分页列表
    public static function listData()
    {
        $db = \ext\db::Init();
		$where['cid'] = self::routerParams('cid');
		$where['status'] = 1;
		$p = self::routerParams('p');
        $num = 10;  //每页显示条数
        $page = ['num' => $num, 'p' => $p, 'return' => ['prev', 'next', 'first', 'last', 'list']];
		$result['data'] = $db->table('article')->where($where)->page($page)->order('id DESC')->select();
        $result['page'] = $db->getPage();
        $result['cid'] = $where['cid'];
        return $result;
    }
	
/* 		//查询 GET值 栏目分页列表
    public static function __listData__()
    {
        $db = \ext\db::Init();
		$where['a.cid'] = self::routerParams('cid');
		$where['a.status'] = 1;
		$p = self::routerParams('p');
        $num = 10;  //每页显示条数
        $page = ['num' => $num, 'p' => $p, 'return' => ['prev', 'next', 'first', 'last', 'list']];
		
		$field = 'b.id as cateid, b.name as catename,b.theme,a.id,a.cid,a.title,a.status,a.time';
		$join = 'LEFT JOIN article_cate b ON a.cid=b.id';
		$result['data'] = $db->table('article a')->field($field)->Join($join)->cache(600)->where($where)->page($page)->order('a.id DESC')->select();
        $result['page'] = $db->getPage();
        return $result;
    } */
	
	
	/**
	*  根据条件 联表 查询指定内容列表  并查出当前所属栏目信息
	*	$cid = 栏目ID   $limit  = 1,10条数,  $cache  = 缓存时间 秒
	*	使用方法: 在模板位置  循环 foreach(\model\article::selectJoinData(7,5,60) as $vo){ echo $vo['catename']; }
	**/
    public static function selectJoinData($cid,$limit,$cache)
    {
		$db = \ext\db::Init();
        $where['a.cid'] = $cid;
		$where['a.status'] = 1;
		$field = 'b.id as cateid , b.name as catename ,a.id,a.cid,a.title,a.status,a.time';
		$join = 'LEFT JOIN article_cate b ON a.cid=b.id';
        $result = $db->table('article a')->field($field)->Join($join)->cache($cache)->where($where)->limit($limit)->select();
        return $result;
    }
	
	
	/**
	*  根据条件 查询指定内容列表
	*	$cid = 栏目ID
	*	$limit  = 1,10条数,
	*	$cache  = 缓存时间 秒
	*	使用方法: 在模板位置  循环 foreach(\model\article::selectData(7,5,60) as $vo){ echo $vo['title']; }
	**/
	public static function selectData($cid,$limit = 10,$cache = 600,$imgbl=0,$attribute=0)
    {
		$db = \ext\db::Init();
		if($cid == 0){
			$where = "status = 1";
		}else{
			$where = "cid IN (".$cid.") AND status = 1";
		}
		if($imgbl == 1){
			$where .= " AND imgbl = 1";
		}
		if($attribute == 1){
			$where .= " AND attribute_a = 1";
		}
		if($attribute == 2){
			$where .= " AND attribute_b = 1";
		}
		if($attribute == 3){
			$where .= " AND attribute_c = 1";
		}
        $result = $db->table('article')->cache($cache)->where($where)->limit($limit)->order('id DESC')->select();
        return $result;
    }
	
	/**
	*  测试 PDO 缓存  前端无调用 
	**/
/* 	public static function pdoSelectData()
    {
		$pdo = \z\pdo::Init();
		$prefix = $pdo->GetConfig();
		$fix = $prefix['prefix'];
		
		$where = $_GET['cid'];
		$sql = "SELECT * FROM {$fix}article WHERE cid=:cid";
		$bind = [':cid'=>self::routerParams('cid')];
		//$pdo->Prepare($sql);    //返回预处理的句柄
		$pdo->Cache(200);
		$result = $pdo->QueryAll($sql, $bind);
        return $result;
    } */

}
