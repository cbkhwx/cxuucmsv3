<?php
namespace model;

class siteconfig
{
	//根据数组键名查找对应的网站信息，此数据长期缓存
    public static function getSiteConfig($key)
    {
		$db = \ext\db::Init();
		$where['name'] = 'siteinfo';
		$result = $db->table('siteconfig')->where($where)->cache(863600)->find();
		$config = unserialize($result['data']);
        return $config[$key];
	}
	
	//根据数组键名查找对应的网站缓存信息，此数据长期缓存
    public static function getCacheConfig($key)
    {
		$db = \ext\db::Init();
		$where['name'] = 'cache';
		$result = $db->table('siteconfig')->where($where)->cache(833600)->find();
		$config = unserialize($result['data']);
        return $config[$key];
    }


}
