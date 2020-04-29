<?php
namespace model;

use root\base\model;

class ondutys extends model
{
	//关联查找一条数据
    public function findData()
    {
        $db = $this->db();
        $where['id'] = $_GET['id'];
        $result = $db->table('onduty')->where($where)->find();
        return $result;
    }
	//查询列表  后台首页调用
    public function selectData($limit)
    {
        $db = $this->db();
        $where['status'] = 1;
        $result = $db->table('onduty')->where($where)->limit($limit)->cache(600)->Order('id DESC')->select();
        return $result;
    }
	
	//添加数据
	public function insertData()
    {
        $db = $this->db('onduty');
        $data = [
			'juname' => $_POST['juname'],
			'chuname' => $_POST['chuname'],
			'yuanname' => $_POST['yuanname'],
			'phone' => $_POST['phone'],
			'ondutytime' => $_POST['ondutytime'],
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
			'juname' => $_POST['juname'],
			'chuname' => $_POST['chuname'],
			'yuanname' => $_POST['yuanname'],
			'phone' => $_POST['phone'],
			'ondutytime' => $_POST['ondutytime'],
			'status' => $_POST['status'],
			];
        $re_key = $db->table('onduty')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化'];
		}
        return $result;
    }
	
	//关联删除一条数据
	public function deleteOneData()
    {
        $db = $this->db();
        $where['id'] = $_POST['id'];
        $result = $db->table('onduty')->where($where)->Delete(); 
        return $result;
    }
	
	//设置状态
	public function switchStatus()
    {
        $db = $this->db();
        $where['id'] = $_POST['id'];
		$data = [
			'status' => $_POST['status']
		];
        $result = $db->table('onduty')->where($where)->Update($data);
        return $result;
    }
	
	//获取数据并分页
	public function jsonPageSelect()
    {
        $db = $this->db();	
        $p = intval($_GET['page'] ?? 0) ?: 1;
        $num = intval($_GET['limit'] ?? 0) ?: 15;
		
        $page = ['num' => $num, 'p' => $p, 'return' => true];
		$result['data'] = $db->table('onduty')->Page($page)->order('id DESC')->select();
		$result['page'] = $db->getPage();
        return $result;
    }

}
