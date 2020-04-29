<?php
namespace model;

use z\cache;

class visits
{
	/**
     * 写入访问量信息
     * id
     * date   datetime
     * visits  int
     */
    public static function insertData()
    {
        //访问量记数先写入Redis缓存 达到量后再写库
        $getCache = cache::R('visits_inc');
        if($getCache){
            $setCache = cache::R('visits_inc', $getCache += 1, 2000, 2);
        }else{
            $setCache = cache::R('visits_inc', 1, 2000, 2);
        }

        if($setCache >= 10){
            $setCache = cache::R('visits_inc', 1, 0, 2);

            $pdo = \z\pdo::Init();
            $prefix = $pdo->GetConfig();
            $fix = $prefix['prefix'];
            $date = date('Y-m-d',time());
            $sql = "UPDATE {$fix}visits SET visits = visits+10 WHERE DATEDIFF(date,NOW()) = 0";
            $result = $pdo->Submit($sql);
            if(empty($result)){
                $insertSql = "INSERT INTO `{$fix}visits` (`id`, `date`, `visits`) VALUES (NULL, '{$date}', '1')";
                $pdo->Submit($insertSql);
            }
        }
    }
	
	/**
     * 获取访问量信息 
     * id
     * date   datetime
     * visits  int
     */
    static public function findData()
    {
        $pdo = \z\pdo::Init();
		$prefix = $pdo->GetConfig();
		$fix = $prefix['prefix'];

        $todaySql = "SELECT * FROM {$fix}visits WHERE DATEDIFF(date,NOW()) = 0";
        $pdo->Cache(600);
        $todayData = $pdo->QueryOne($todaySql);
        $data['today'] = $todayData['visits'];
        $yesterdaySql =  "SELECT * FROM {$fix}visits WHERE DATEDIFF(date,NOW()) = -1";
        $pdo->Cache(600);
        $yesterdayData = $pdo->QueryOne($yesterdaySql);
        if($yesterdayData){
            $data['yesterday'] = $yesterdayData['visits'];
        }else{
            $data['yesterday'] = 0;
        }
       
        $sumSql =  "SELECT SUM(visits) FROM {$fix}visits";
        $pdo->Cache(600);
        $sum = $pdo->QueryOne($sumSql);
        $maxSql =  "SELECT MAX(visits) FROM {$fix}visits";
        $pdo->Cache(600);        
        $max = $pdo->QueryOne($maxSql);
        $data['sum']=$sum['SUM(visits)'];
        $data['max']=$max['MAX(visits)'];
        return $data;
    }

}
