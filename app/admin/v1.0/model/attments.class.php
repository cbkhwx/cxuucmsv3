<?php
namespace model;

use root\base\model;

class attments extends model
{
	//获取数据
    public function FindData()
    {
        $db = $this->db();
		$where['name'] = 'siteinfo';
		$result = $db->table('attments')->where($where)->find();
		$config = unserialize($result['data']);
        return $config;
    }
	
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
	
	//插入数据
	public function updateData()
    {
        $db = $this->db();
        $data = [
			'sitename' => $_POST['sitename'],
			'siteurl' => $_POST['siteurl'],
			'keywords' => $_POST['keywords'],
			'descript' => $_POST['descript'],
			'copyright' => $_POST['copyright'],
			'uploadsize' => $_POST['uploadsize'],
			'uploadext' => $_POST['uploadext'],
			];
		$where['name'] = 'siteinfo';
		$ser_data['data'] = serialize($data);

        $re_key = $db->table('attments')->Where($where)->Update($ser_data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化！'];
		}
        return $result;
    }
	
}
