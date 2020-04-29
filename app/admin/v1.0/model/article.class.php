<?php
namespace model;

use root\base\model;

class article extends model
{
	//信息统计查询
    public function findCountData()
    {
        $db = $this->db('article');
		//$result = $db->where('status = 0')->Count();
		$resultStatus = $db->Count();   
        return $resultStatus;
    }

	
	//关联查找一条数据
    public function findData()
    {
        $db = $this->db();
        $where['a.id'] = $_GET['id'];
		$join[] = 'LEFT JOIN article_content b ON a.id=b.aid';
		$join[] = 'LEFT JOIN attments c ON a.attid=c.attid';
        $result = $db->table('article a')->Join($join)->where($where)->find();
        return $result;
    }
	
	//添加数据
	public function insertData()
    {
		//插入数据信息部分
        $db = $this->db('article');
		$attid = empty($_POST['attid'])?null:$_POST['attid'];
        $data = [
			'cid' => $_POST['cid'],
			'title' => $_POST['title'],
			'attid' => $attid,
			'attribute_a' => $_POST['attribute_a'],
			'attribute_b' => $_POST['attribute_b'],
			'attribute_c' => $_POST['attribute_c'],
			'examine' => $_POST['examine'],
			'img' => $_POST['img'],
			'imgbl' => empty($_POST['img'])?0:1,
			'time' => date('Y-m-d H:i:s',time()),
			'status' => $_POST['status'],
			'uid' => sessionInfo("userid"),
			'gid' => sessionInfo("gid"),
			];
        $re_key = $db->insert($data);//$this->error($db->getError());
		if($re_key){
			$result = ['key' => $re_key,'status' => 1,'msg' => '添加成功','cid' => $_POST['cid']];
		}else{
			$result = ['status' => 0,'msg' => '数据错误！添加失败'];
		}
		//根据主键插入内容部分
  		$db_content = $this->db('article_content');
		$data_content = [
			'content' => $_POST['content'],
			'aid' => $re_key,
		];
		$result_content = $db_content->insert($data_content);
        return $result;
    }
	//关联更新数据
	public function updateData()
    {
        $db = $this->db();
		$where['a.id'] = $_POST['id'];
		$attid = empty($_POST['attid'])?null:$_POST['attid'];
        $data = [
			'a.cid' => $_POST['cid'],
			'a.title' => $_POST['title'],
			'a.attid' => $attid,
			'a.attribute_a' => $_POST['attribute_a'],
			'a.attribute_b' => $_POST['attribute_b'],
			'a.attribute_c' => $_POST['attribute_c'],
			'a.examine' => $_POST['examine'],
			'a.img' => $_POST['img'],
			'a.imgbl' => empty($_POST['img'])?0:1,
			'b.content' => $_POST['content'],
			//'a.time' => date('Y-m-d H:i:s',time()),
			'a.status' => $_POST['status'],
			];
		$join = 'LEFT JOIN article_content b ON a.id=b.aid';
        $re_key = $db->table('article a')->Join($join)->Where($where)->Update($data);//$this->error($db->getError());
		if($re_key){
			$result = ['key' => $re_key,'status' => 1,'msg' => '修改成功','cid' => $_POST['cid']];
		}else{
			$result = ['status' => 0,'msg' => '数据没有变化！'];
		}
        return $result;
    }
	
	//关联删除一条数据
	public function deleteOneData()
    {
		$pdo = \z\pdo::Init();
		 //获取PDO设置
		$prefix = $pdo->GetConfig();
		$fix = $prefix['prefix'];
		//关联删除
		$sql = "DELETE {$fix}article,{$fix}article_content from {$fix}article LEFT JOIN {$fix}article_content ON {$fix}article.id={$fix}article_content.aid WHERE {$fix}article.id=:id";
		$bind = [':id'=>$_POST['id']];
		$pdo->Prepare($sql);    //返回预处理的句柄
		$result = $pdo->Query($sql, $bind);
		
/*   保留样式  未测试  DB的关联删除方法
        $db = $this->db();
        $where['a.id'] = $_POST['id'];
		$field = 'article,article_content';
		$join = 'LEFT JOIN article_content b ON a.id=b.aid';
        $result = $db->table('article a')->field($field)->Join($join)->where($where)->Delete(); */
        return $result;
    }
	
	//审核一条数据
	public function switchStatus()
    {
        $db = $this->db();
        $where['id'] = $_POST['id'];
		$data = [
			'status' => $_POST['status']
		];
        $result = $db->table('article')->where($where)->Update($data);
        return $result;
    }
	
	//获取栏目数据并分页
	public function jsonPageSelect()
    {
        $db = $this->db();
		if (sessionInfo('gid') != 1) {
			if(isset($_GET['title'])){
				$where['a.title LIKE'] = '%'.$_GET['title'].'%';
			}
			$where['a.cid'] = intval($_GET['cid']);
			$where['a.uid'] = sessionInfo("userid");
		}else{
			if(isset($_GET['title'])){
				$where['a.title LIKE'] = '%'.$_GET['title'].'%';
			}
			$where['a.cid'] = intval($_GET['cid']);
		}
		
        $p = intval($_GET['page'] ?? 0) ?: 1;
        $num = intval($_GET['limit'] ?? 0) ?: 15;
		
        $page = ['num' => $num, 'p' => $p, 'return' => true];
		
		//关联 article_cate  admin_user admin_group 表查询
		$field = 'b.id as cateid , b.name as catename,g.groupname,u.nickname ,a.id,a.cid,a.title,a.imgbl,a.attribute_a,a.attribute_b,a.attribute_c,a.status,a.time';
		$join[] = 'LEFT JOIN article_cate b ON a.cid=b.id';
		$join[] = 'LEFT JOIN admin_user u ON a.uid=u.id';
		$join[] = 'LEFT JOIN admin_group g ON u.gid=g.id';
		$result['data'] = $db->table('article a')->field($field)->where($where)->join($join)->Page($page)->order('a.id DESC')->select();
		$result['page'] = $db->getPage();

        return $result;
    }

	
}
