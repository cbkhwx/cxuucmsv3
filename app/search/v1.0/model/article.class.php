<?php
namespace model;

class article
{
	//搜索列表
    public static function searchJoinData()
    {
        $db = \ext\db::Init();
        //$where['a.title like'] = '`%'.$_GET['keywords'].'%`';
		$p = $_GET['p'];
        $num = 20;  //每页显示条数
        $page = ['num' => $num, 'p' => $p, 'return' => ['prev', 'next', 'first', 'last', 'list']];
		$field = 'b.id as cateid , b.name as catename ,a.id,a.cid,a.title,a.status,a.time';
		$join = 'LEFT JOIN article_cate b ON a.cid=b.id WHERE a.title LIKE \'%'.$_GET['keywords'].'%\'';	
        $result['data'] = $db->table('article a')->field($field)->Join($join)->page($page)->order('a.id DESC')->select();
        $result['page'] = $db->getPage();
        return $result;
    }
}
