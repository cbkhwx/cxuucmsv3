<?php
namespace model;

use z\cache;

class visits
{

	/**
     * 获取访问量信息 
     * id
     * date   datetime
     * visits  int
     */
    static public function selectData()
    {
        $pdo = \z\pdo::Init();
		$prefix = $pdo->GetConfig();
		$fix = $prefix['prefix'];
        $Sql = "SELECT * FROM {$fix}visits order by id asc";
        $data = $pdo->QueryAll($Sql);
        return $data;
    }

}
