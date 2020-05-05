<?php
namespace model;

use z\cache;
use model\siteconfig;

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
        $d = new siteconfig;
        $swtich = $d->getCacheConfig('visitscache');
        
        if($swtich == 1){
            $time = $d->getCacheConfig('visitstime');
            $num = $d->getCacheConfig('visitsnum');//可根据网站访问量适当将数据设置得大一些，建议设置成单数

            //如果开启缓存，访问量记数先写入Redis缓存 达到量后再写库
            $getCache = cache::R('visits_inc');
            if($getCache){
                $setCache = cache::R('visits_inc', $getCache += 1, $time, 2);
            }else{
                $setCache = cache::R('visits_inc', 1, $time, 2);
            }

            if($setCache >= $num){
                cache::R('visits_inc', 0, $time, 2);
                $pdo = \z\pdo::Init();
                $prefix = $pdo->GetConfig();
                $fix = $prefix['prefix'];
                $date = date('Y-m-d',time());
                $sql = "UPDATE {$fix}visits SET visits = visits+{$num} WHERE DATEDIFF(date,NOW()) = 0";
                $result = $pdo->Submit($sql);
                if(empty($result)){
                    $insertSql = "INSERT INTO `{$fix}visits` (`id`, `date`, `visits`) VALUES (NULL, '{$date}', '{$num}')";
                    $pdo->Submit($insertSql);
                }
            }
        }else{
            $pdo = \z\pdo::Init();
            $prefix = $pdo->GetConfig();
            $fix = $prefix['prefix'];
            $date = date('Y-m-d',time());
            $sql = "UPDATE {$fix}visits SET visits = visits+1 WHERE DATEDIFF(date,NOW()) = 0";
            $result = $pdo->Submit($sql);
            if(empty($result)){
                $insertSql = "INSERT INTO `{$fix}visits` (`id`, `date`, `visits`) VALUES (NULL, '{$date}', 1)";
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
        $d = new siteconfig;
        $time = $d->getCacheConfig('visitsshowtime');

        $pdo = \z\pdo::Init();
		$prefix = $pdo->GetConfig();
		$fix = $prefix['prefix'];

        $todaySql = "SELECT * FROM {$fix}visits WHERE DATEDIFF(date,NOW()) = 0";
        $pdo->Cache($time);
        $todayData = $pdo->QueryOne($todaySql);
        $data['today'] = $todayData['visits'];
        $yesterdaySql =  "SELECT * FROM {$fix}visits WHERE DATEDIFF(date,NOW()) = -1";
        $pdo->Cache($time);
        $yesterdayData = $pdo->QueryOne($yesterdaySql);
        if($yesterdayData){
            $data['yesterday'] = $yesterdayData['visits'];
        }else{
            $data['yesterday'] = 0;
        }
       
        $sumSql =  "SELECT SUM(visits) FROM {$fix}visits";
        $pdo->Cache($time);
        $sum = $pdo->QueryOne($sumSql);
        $maxSql =  "SELECT MAX(visits) FROM {$fix}visits";
        $pdo->Cache($time);
        $max = $pdo->QueryOne($maxSql);
        $data['sum']=$sum['SUM(visits)'];
        $data['max']=$max['MAX(visits)'];
        return $data;
    }

}
