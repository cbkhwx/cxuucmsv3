<?php
/**

前端综合 数据模型  
cxuucms 20200415 
龙啸轩内容管理系统

**/
namespace model;

class common
{
	//查询用户组的ID 和 用户组名列表，此数据长期缓存
    protected static function getAdminGroup()
    {
		$db = \ext\db::Init();
		$result = $db->table('admin_group')->Field('id, groupname')->cache(86400)->select();
        return $result;
    }
	
	//查询用户的ID 和 昵称名列表，此数据长期缓存
    protected static function getAdminUser()
    {
		$db = \ext\db::Init();
		$result = $db->table('admin_user')->Field('id, nickname')->cache(88600)->select();
        return $result;
    }
	
	//查询所有栏目列表，此数据长期缓存
	protected static function getCateData()
    {
		$db = \ext\db::Init();
		$result = $db->table('article_cate')->Field('id, pid, name, theme,type')->cache(92600)->Select();
        return $result;
    }
	
	//文章内容栏目路径显示
	//foreach(\model\article_cate::getCateUrlData($cid) as $value){
    public static function getCateUrlData($cid)
    {
		$cateListData = self::getCateData();
		$cate = new \extend\Category(array('id','pid','name','cname'));
		$cateList = $cate->getPath($cateListData, $cid);
		sort($cateList);// 以升序对数组排序
        return $cateList;
    }
	
	//根据已经查询到的数组，查找指定的一条栏目数据
    public static function findCateData($cid)
    {
		$cateListData = self::getCateData();
		$find = filter_by_value($cateListData, 'id', $cid);
		$resName = array_column($find,'name');
		$resTheme = array_column($find,'theme');
		$result['name'] = $resName[0];
		$result['theme'] = $resTheme[0];
        return $result;
    }
	
	//根据已经查询到的数组，查找指定的一条用户组数据
    public static function findAdminGroupData($gid)
    {
		$list = self::getAdminGroup();
		$find = filter_by_value($list, 'id', $gid);
		$result['groupname'] = array_column($find,'groupname');
        return $result['groupname'][0];
    }
	
	//根据已经查询到的数组，查找指定的一条用户数据
    public static function findAdminUserData($uid)
    {
		$list = self::getAdminUser();
		$find = filter_by_value($list, 'id', $uid);
		$result['nickname'] = array_column($find,'nickname');
        return $result['nickname'][0];
    }

}
