<?php
namespace model;

use root\base\model;

class images_image extends model
{
	//查找一条数据
    public function findData()
    {
        $db = $this->db();
        $where['id'] = $_GET['id'];
        $result = $db->table('images_image')->where($where)->find();
        return $result;
    }
	
	//查找一条所属图集的数据
    public function findImagesData()
    {
        $db = $this->db();
        $where['id'] = $_GET['aid'];
        $result = $db->table('images')->where($where)->find();
        return $result;
    }
	
	//添加数据
	public function insertData()
    {
        $db = $this->db('images_image');
        $data = [
			'aid' => $_POST['aid'],
			'imgsrc' => $_POST['imgsrc'],
			'info' => $_POST['info'],
			];
        $re_key = $db->insert($data);
		if($re_key){
			$result = ['key' => $re_key,'status' => 1,'msg' => '添加成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据错误！添加失败'];
		}
        return $result;
    }
	//更新数据
	public function updateData()
    {
        $db = $this->db();
		$where['id'] = $_POST['id'];
        $data = [
			'imgsrc' => $_POST['imgsrc'],
			'info' => $_POST['info'],
			];
        $re_key = $db->table('images_image')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化'];
		}
        return $result;
    }
	
	//删除一条数据
	public function deleteOneData()
    {
        $db = $this->db();
        $where['id'] = $_POST['id'];
        $result = $db->table('images_image')->where($where)->Delete(); 
        return $result;
    }
	

	
	//获取数据并分页
	public function jsonPageSelect()
    {
        $db = $this->db();
        $p = intval($_GET['page'] ?? 0) ?: 1;
        $num = intval($_GET['limit'] ?? 0) ?: 15;
		$where['aid'] = $_GET['aid'];
		
        $page = ['num' => $num, 'p' => $p, 'return' => true];
		$result['data'] = $db->table('images_image')->where($where)->Page($page)->order('id DESC')->select();
		$result['page'] = $db->getPage();
        return $result;
    }

}
