<?php
namespace model;

use root\base\model;

class admin_user extends model
{
	//登录判断用户名和密码
    public function findAdmin()
    {
        $db = $this->db();
        $where['username'] = $_POST['username'];
		$where['password'] = md5($_POST['password']);
        $result = $db->table('admin_user')->where($where)->find();
        return $result;
    }
	//将登录信息写入数据库
	public function loginDbInsert($userId)
    {
        $db = $this->db('admin_user');
		$where = ['id'=>$userId];
		$updateDate = [
			'logintime' => date('Y-m-d H:i:s',time()),
			'loginip' => getip(),
		];
		$result = $db->where($where)->update($updateDate) ? true : $this->error($db->getError());
		return $result;
    }
	
	//查找一条信息
    public function findData()
    {
        $db = $this->db();
        $where['id'] = $_GET['id'];
        $result = $db->table('admin_user')->where($where)->find();
        return $result;
    }
	
	//判断用户名是否存在
    public function checkNameData()
    {
        $db = $this->db();
		if(empty($_POST['id'])){
			$where['username'] = $_POST['username'];
		}else{
			//验证用户名是否存在 查询不等当前用户的数据进行比对
			$where = [
			'id <>' => $_GET['id'],
			'username'=>$_POST['username'],
			];
		}
        $result = $db->table('admin_user')->where($where)->find();
        return $result;
    }
	//添加数据
	public function insertData()
    {
		//插入数据信息部分
        $db = $this->db('admin_user');        
        $data = [
			'gid' => $_POST['gid'],
			'username' => $_POST['username'],
			'nickname' => $_POST['nickname'],
			'password' => md5(trim($_POST['password'])),
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
        if(!empty($_POST['password'])){
			$data = [
				'gid' => $_POST['gid'],
				'username' => $_POST['username'],
				'nickname' => $_POST['nickname'],
				'password' => md5(trim($_POST['password'])),
				'status' => $_POST['status'],
			];
		}else{
			$data = [
			'gid' => $_POST['gid'],
			'username' => $_POST['username'],
			'nickname' => $_POST['nickname'],
			'status' => $_POST['status'],
			];
		}
        $re_key = $db->table('admin_user')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化'];
		}
        return $result;
    }
	
	//用户自行修改密码
	public function passwordEdit()
    {
        $db = $this->db();
		$where['id'] = $_POST['id'];
        if(!empty($_POST['password'])){
			$data = [
				'nickname' => $_POST['nickname'],
				'password' => md5(trim($_POST['password'])),
			];
		}else{
			$data = [
			'nickname' => $_POST['nickname'],
			];
		}
        $re_key = $db->table('admin_user')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '密码没有变化'];
		}
        return $result;
    }
	
	public function switchStatus(){
		$db = $this->db();
        $where['id'] = $_POST['id'];
		$data = [
			'status' => $_POST['status']
		];
        $result = $db->table('admin_user')->where($where)->Update($data);
        return $result;
		
	}
	
	
	//删除一条数据
	public function deleteOneData()
    {
		$db = $this->db();
        $where['id'] = $_POST['id'];
        $result = $db->table('admin_user')->where($where)->Delete(); 
        return $result;
    }
	
	
	//获取数据并分页
	public function jsonPageSelect()
    {
        $db = $this->db();
				
        $p = intval($_GET['page'] ?? 0) ?: 1;
        $num = intval($_GET['limit'] ?? 0) ?: 10;
		
        $page = ['num' => $num, 'p' => $p, 'return' => true];
		
		//关联 article_cate 表查询  并设置 article_cate.id  别名 cateid             where IN a.cid(1,2,3)
		$field = 'b.id as groupid,b.groupname,a.id,a.gid,a.username,a.nickname,a.logintime,a.loginip,a.status';
		$join = 'LEFT JOIN admin_group b ON a.gid=b.id';
		
		$result['data'] = $db->table('admin_user a')->field($field)->join($join)->Page($page)->order('a.id DESC')->select();
		$result['page'] = $db->getPage();

        return $result;
    }
}
