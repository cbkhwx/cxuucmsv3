<?php
namespace model;

use root\base\model;

class article_cate extends model
{
    public function FindData()
    {
        $db = $this->db();
        $where['id'] = $_GET['id'];
        $result = $db->table('article_cate')->where($where)->find();
        return $result;
    }
	
	//根据栏目权限获取栏目列表  设置$auth = 1  走权限，否则查询全部数据
	public function SelectData($auth = null)
    {
		$pdo = \z\pdo::Init();
		$prefix = $pdo->GetConfig();//获取PDO设置
		$fix = $prefix['prefix'];
		if($auth == 1){
			$channlid = channlrole();
			if (sessionInfo('gid') != 1) {
				$sql = "SELECT * FROM `{$fix}article_cate` WHERE `id` IN ({$channlid})";
			}else{
				$sql = "SELECT * FROM `{$fix}article_cate`";
			}
		}else{
			$sql = "SELECT * FROM `{$fix}article_cate`";
		}
		$result = $pdo->QueryAll($sql);
        return $result;
    }

	//根据栏目权限获取栏目树列表
	public function SelectTreeData()
    {
		$cate = new \extend\Category(array('id','pid','name','cname'));
		$cateListTree = $cate->getTree(self::SelectData(1));
        return $cateListTree;
    }

	//根据栏目权限获取栏目JSON列表
	public function jsonSelectData()
    {
        $result = self::SelectData(1);
        return $result;
    }
	//添加数据
	public function insertData()
    {
        $db = $this->db('article_cate');        
        $data = [
			'pid' => $_POST['pid'],
			'name' => $_POST['name'],
			'type' => $_POST['type'],
			'theme' => $_POST['theme'],
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
			'pid' => $_POST['pid'],
			'name' => $_POST['name'],
			'type' => $_POST['type'],
			'theme' => $_POST['theme'],
			];
        $re_key = $db->table('article_cate')->Where($where)->Update($data);
		if($re_key){
			$result = ['status' => 1,'msg' => '修改成功'];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化'];
		}
        return $result;
    }

}
