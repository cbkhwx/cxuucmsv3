<?php
namespace model;

use root\base\model;

class attments extends model
{
	
	//添加数据
	public function insertData($atturl,$priname,$ext,$size)
    {
        $db = $this->db('attments');        
        $data = [
			'atturl' => $atturl,
			'priname' => $priname,
			'ext' => $ext,
			'size' => $size,
			];
        $re_key = $db->insert($data);
		if($re_key){
			$result = $re_key;
		}else{
			$result = 'error';
		}
        return $result;
    }	
}
