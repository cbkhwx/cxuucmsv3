<?php
namespace model;

use z\cache;

class ondutys
{
   //关联查找一条数据
   public static function findData()
   {
         $db = \ext\db::Init();
        $result = $db->table('onduty')->where('DATEDIFF(ondutytime,NOW()) = 0')->find();
        return $result;
   }

}
