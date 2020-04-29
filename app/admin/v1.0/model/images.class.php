<?php
namespace model;

use root\base\model;

class images extends model
{
	//关联查找一条数据
    public function findData()
    {
        $db = $this->db();
        $where['id'] = $_GET['id'];
        $result = $db->table('images')->where($where)->find();
        return $result;
    }
	//查询列表
    public function selectData($limit)
    {
        $db = $this->db();
        $where['status'] = 1;
        $result = $db->table('images')->where($where)->limit($limit)->cache(600)->Order('id DESC')->select();
        return $result;
    }
	
	//添加数据
	public function insertData()
    {
        $db = $this->db('images');
        $data = [
			'title' => $_POST['title'],
			'img' => $_POST['img'],
			'auther' => $_POST['auther'],
			'content' => $_POST['content'],
			'time' => date('Y-m-d H:i:s',time()),
			'status' => $_POST['status'],
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
			'title' => $_POST['title'],
			'img' => $_POST['img'],
			'auther' => $_POST['auther'],
			'content' => $_POST['content'],
			'status' => $_POST['status'],
			];
        $re_key = $db->table('images')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化'];
		}
        return $result;
    }
	
	//判断删除一条数据
	public function deleteOneData()
    {
        $db = $this->db();
        $find['aid'] = $_POST['id'];
		$find = $db->table('images_image')->where($find)->find(); 
		if($find){
			return false;
		}else{
			$where['id'] = $_POST['id'];
			$result = $db->table('images')->where($where)->Delete(); 
			return $result;
		}
        
    }
	
	//设置状态
	public function switchStatus()
    {
        $db = $this->db();
        $where['id'] = $_POST['id'];
		$data = [
			'status' => $_POST['status']
		];
        $result = $db->table('images')->where($where)->Update($data);
        return $result;
    }
	
	//获取数据并分页
	public function jsonPageSelect()
    {
        $db = $this->db();
        $p = intval($_GET['page'] ?? 0) ?: 1;
        $num = intval($_GET['limit'] ?? 0) ?: 15;
		
        $page = ['num' => $num, 'p' => $p, 'return' => true];
		$result['data'] = $db->table('images')->Page($page)->order('id DESC')->select();
		$result['page'] = $db->getPage();
        return $result;
    }

}
