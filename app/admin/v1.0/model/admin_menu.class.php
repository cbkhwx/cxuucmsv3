<?php
namespace model;

use root\base\model;

class admin_menu extends model
{
	//查找一条数据
    public function findData()
    {
        $db = $this->db();
        $where['id'] = $_GET['id'];
        $result = $db->table('admin_menu')->where($where)->find();
        return $result;
    }
	
	//根据权限查找顶级菜单数据
    public function selectData()
    {
        $pdo = \z\pdo::Init();
		$prefix = $pdo->GetConfig();//获取PDO设置
		$fix = $prefix['prefix'];
		
		if (sessionInfo('gid') != 1) {
			$menuroleid = adminMenuRole();
			$sql = "SELECT * FROM `{$fix}admin_menu` WHERE `pid` = 0 AND `id` IN ({$menuroleid}) ORDER BY `sort` ASC";
		}else{
			$sql = "SELECT * FROM `{$fix}admin_menu` WHERE `pid` = 0 ORDER BY `sort` ASC";
		}
		$result = $pdo->QueryAll($sql);
        return $result;
    }
	
	//根据权限查找二级菜单数据
    public function selectSecendData()
    {
        $pdo = \z\pdo::Init();
		$prefix = $pdo->GetConfig();//获取PDO设置
		$fix = $prefix['prefix'];
		$getpid = $_GET['pid'];
		if (sessionInfo('gid') != 1) {
			$menuroleid = adminMenuRole();
			$sql = "SELECT * FROM `{$fix}admin_menu` WHERE `pid` = {$getpid} AND `id` IN ({$menuroleid}) ORDER BY `sort` ASC";
		}else{
			$sql = "SELECT * FROM `{$fix}admin_menu` WHERE `pid` = {$getpid} ORDER BY `sort` ASC";
		}
		$result = $pdo->QueryAll($sql);
        return $result;
    }
	
	//添加数据
	public function insertData()
    {
		//插入数据信息部分
        $db = $this->db('admin_menu');        
        $data = [
			'pid' => $_POST['pid'],
			'name' => $_POST['name'],
			'controller' => $_POST['controller'],
			'action' => $_POST['action'],
			'sort' => $_POST['sort'],
			'ico' => $_POST['ico'],
			];
        $re_key = $db->insert($data);//$this->error($db->getError());
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
			'pid' => $_POST['pid'],
			'name' => $_POST['name'],
			'controller' => $_POST['controller'],
			'sort' => $_POST['sort'],
			'action' => $_POST['action'],
			'ico' => $_POST['ico'],
			];
        $re_key = $db->table('admin_menu')->Where($where)->Update($data);
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
        $result = $db->table('admin_menu')->where($where)->Delete(); 
        return $result;
    }
	
	
	//获取全部数据提供JSON生成
	public function jsonPageSelect()
    {
        $db = $this->db();
        $result = $db->table('admin_menu')->order('sort ASC')->select();
        return $result;
    }

	
}
