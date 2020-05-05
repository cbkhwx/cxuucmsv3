<?php
namespace model;

use root\base\model;

class siteconfig extends model
{
	//获取数据
    public function FindData()
    {
		$db = $this->db();
		if(isset($_GET['name'])){
			$where['name'] = $_GET['name'];
		}else{
			$where['name'] = 'siteinfo';//默认获取网站设置
		}		
		$result = $db->table('siteconfig')->where($where)->find();
		$config = unserialize($result['data']);
        return $config;
    }
	
	
	//更新数据
	public function updateData($name)
    {
		$db = $this->db();
		if($name == 'siteinfo'){
			$data = [
			'sitename' => $_POST['sitename'],
			'siteurl' => $_POST['siteurl'],
			'keywords' => $_POST['keywords'],
			'descript' => $_POST['descript'],
			'copyright' => $_POST['copyright'],
			
			];
		}else if($name == 'cache'){
			$data = [
			'indexhtml' => $_POST['indexhtml'],
			'indexhtmltime' => $_POST['indexhtmltime'],
			'visitscache' => $_POST['visitscache'],
			'visitsnum' => $_POST['visitsnum'],
			'visitstime' => $_POST['visitstime'],
			'visitsshowtime' => $_POST['visitsshowtime'],
			];
		}else if($name == 'upload'){
			$data = [
			'uploadsize' => $_POST['uploadsize'],
			'imguploadext' => $_POST['imguploadext'],
			'attuploadext' => $_POST['attuploadext'],
			];
		}

		$where['name'] = $name;
		$ser_data['data'] = serialize($data);

        $re_key = $db->table('siteconfig')->Where($where)->Update($ser_data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化！'];
		}
        return $result;
	}
	
	//根据数组键名查找对应的网站上传设置信息
    public static function getUploadConfigAttment()
    {
		$db = \ext\db::Init();
		$where['name'] = 'upload';
		$result = $db->table('siteconfig')->where($where)->cache(833600)->find();
		$config = unserialize($result['data']);
		$ext = $config['attuploadext'];
		$newarray = explode('|', $ext);//['.doc', '.xls', '.xlsx', '.docx', '.rar', '.7z', '.txt','.zip']
		return $newarray;
	}
	
	//根据数组键名查找对应的网站上传设置信息
    public static function getUploadConfigImage()
    {
		$db = \ext\db::Init();
		$where['name'] = 'upload';
		$result = $db->table('siteconfig')->where($where)->cache(833600)->find();
		$config = unserialize($result['data']);
		$ext = $config['imguploadext'];
		$newarray = explode('|', $ext);
		return $newarray;
	}

	//转换网站上传设置信息，供layui上传组件使用
	public static function getUploadAttmentSwitch()
	{
		$extarray = self::getUploadConfigAttment();//['.doc', '.xls', '.xlsx', '.docx', '.rar', '.7z', '.txt','.zip']
		$newstring = implode('|', $extarray);
		$extstring = str_replace('.','',$newstring);
		return $extstring;
	}
	
	//转换网站上传设置信息，供layui上传组件使用
    public static function getUploadImageSwitch()
    {
		$extarray = self::getUploadConfigImage();
		$newstring = implode('|', $extarray);
		$extstring = str_replace('.','',$newstring);
		return $extstring;
	}
	
}
