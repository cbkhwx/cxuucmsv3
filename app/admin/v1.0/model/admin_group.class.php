<?php
namespace model;

use root\base\model;

class admin_group extends model
{
	//查询一条信息，用于登录 传参
    public function findGroup($find)
    {
        $db = $this->db();
        $where['id'] = $find;
        $result = $db->table('admin_group')->where($where)->find();
        return $result;
    }
	
	//查找一条数据
    public function findData()
    {
        $db = $this->db();
        $where['id'] = $_GET['id'];
        $result = $db->table('admin_group')->where($where)->find();
        return $result;
    }
	
	//查询列表
	public function selectGroup()
    {
        $db = $this->db();
        $result = $db->table('admin_group')->select();
        return $result;
    }
	
	//获取数据并分页
	public function jsonPageSelect()
    {
        $db = $this->db();	
        $p = intval($_GET['page'] ?? 0) ?: 1;
        $num = intval($_GET['limit'] ?? 0) ?: 10;
		
        $page = ['num' => $num, 'p' => $p, 'return' => true];
		$result['data'] = $db->table('admin_group')->Page($page)->order('id DESC')->select();
		$result['page'] = $db->getPage();
        return $result;
    }
	
	//判断用户组名是否存在
    public function checkNameData()
    {
        $db = $this->db();
		if(empty($_POST['id'])){
			$where['groupname'] = $_POST['groupname'];
		}else{
			//验证用户组名是否存在 查询不等当前ID的数据进行比对
			$where = [
			'id <>' => $_GET['id'],
			'groupname'=>$_POST['groupname'],
			];
		}
        $result = $db->table('admin_group')->where($where)->find();
        return $result;
    }
	//添加数据
	public function insertData()
    {
        $db = $this->db('admin_group');        
        $data = [
			'groupname' => $_POST['groupname'],
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
			'groupname' => $_POST['groupname'],
			];
        $re_key = $db->table('admin_group')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化'];
		}
        return $result;
    }
	
	//更新数据
	public function updateSystemroleData()
    {
        $db = $this->db();
		$where['id'] = $_POST['id'];
        $data = [
			'systemrole' => serialize($_POST['systemrole']),
			];
        $re_key = $db->table('admin_group')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化'];
		}
        return $result;
    }
	
	//更新数据
	public function updateChannlroleData()
    {
        $db = $this->db();
		$where['id'] = $_POST['id'];
        $data = [
			'channlrole' => serialize($_POST['channlrole']),
			];
        $re_key = $db->table('admin_group')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化'];
		}
        return $result;
    }
	
	//更新数据
	public function updateMenuroleData()
    {
        $db = $this->db();
		$where['id'] = $_POST['id'];
        $data = [
			'menurole' => serialize($_POST['menurole']),
			];
        $re_key = $db->table('admin_group')->Where($where)->Update($data);
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
		$find['aid'] = $_POST['id'];
		$find = $db->table('admin_user')->where($find)->find(); 
		if($find){
			return false;
		}else{
			$where['id'] = $_POST['id'];
			$result = $db->table('admin_group')->where($where)->Delete(); 
			return $result;
		}
    }

}
