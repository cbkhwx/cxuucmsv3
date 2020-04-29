<?php
namespace model;

use root\base\model;

class members extends model
{

	//查找一条信息
    public function findData()
    {
        $db = $this->db();
        $where['id'] = $_GET['id'];
        $result = $db->table('member')->where($where)->find();
        return $result;
    }
	
	//添加数据
	public function insertData()
    {
		//插入数据信息部分
        $db = $this->db('member');        
        $data = [
			'name' => $_POST['name'],
			'duties' => $_POST['duties'],
			'photo' => $_POST['photo'],
			'duty' => $_POST['duty'],
			'sort' => $_POST['sort'],
			'status' => $_POST['status'],
			];	
        $re_key = $db->insert($data);//$this->error($db->getError());
		if($re_key){
			$result = ['key' => $re_key,'status' => 1,'msg' => '添加成功','cid' => $_POST['cid']];
		}else{
			$result = ['status' => 0,'msg' => '数据错误！添加失败'];
		}
        return $result;
    }
	//关联更新数据
	public function updateData()
    {
        $db = $this->db();
		$where['id'] = $_POST['id'];
		$data = [
			'name' => $_POST['name'],
			'duties' => $_POST['duties'],
			'photo' => $_POST['photo'],
			'duty' => $_POST['duty'],
			'sort' => $_POST['sort'],
			'status' => $_POST['status'],
		];

        $re_key = $db->table('member')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化'];
		}
        return $result;
    }
	
	
	public function switchStatus(){
		$db = $this->db();
        $where['id'] = $_POST['id'];
		$data = [
			'status' => $_POST['status']
		];
        $result = $db->table('member')->where($where)->Update($data);
        return $result;
		
	}
	
	
	//删除一条数据
	public function deleteOneData()
    {
		$db = $this->db();
        $where['id'] = $_POST['id'];
        $result = $db->table('member')->where($where)->Delete(); 
        return $result;
    }
	
	
	//获取数据并分页
	public function jsonPageSelect()
    {
        $db = $this->db();
        $p = intval($_GET['page'] ?? 0) ?: 1;
        $num = intval($_GET['limit'] ?? 0) ?: 15;
        $page = ['num' => $num, 'p' => $p, 'return' => true];
		$result['data'] = $db->table('member')->Page($page)->order('sort asc')->select();
		$result['page'] = $db->getPage();
        return $result;
    }
}
