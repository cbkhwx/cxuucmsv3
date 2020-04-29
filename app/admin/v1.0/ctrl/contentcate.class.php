<?php
namespace ctrl;

use \middleware\adminrole;
use model\article_cate;
use z\view;
class contentcate
{
	static function init(){
			$check = new \middleware\check();
			$check->check();
		}
		
	public static function index(){
		adminrole::auth();//判断用户权限
        view::display();
	}
	
	//栏目编辑列表页调用
	public static function jsonlist(){
		adminrole::auth();//判断用户权限
		$m = new article_cate;
		$list = $m->SelectData();
		$jsonlist = array();
		$jsonlist['code'] = 1;
		$jsonlist['data'] = generateTree($list);
		exit(json_encode($jsonlist));
	}
	
	//contentCateTreeJsonlist
	//栏目分类列表展示
	//权限编辑菜单调用
	public static function contentCateTreeJsonlist(){
		adminrole::auth();//判断用户权限
		$m = new article_cate;
		$list = $m->SelectData();
		$jsonlist['code'] = 0;
		$jsonlist['msg'] = '操作成功';
		$jsonlist['data'] = contentCateTree($list);
		exit(json_encode($jsonlist));
	}
	
	
	public static function addview(){
		adminrole::auth();//判断用户权限
		//实例化模型
		$m = new article_cate;
		$list = $m->SelectTreeData();
		view::assign('list',$list);
		view::display();

	}
	
	public static function add(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['pid'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		$m = new article_cate;
		$result = $m->insertData();
  		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	public static function editview(){
		adminrole::auth();//判断用户权限
		if(isset($_GET['id'])){
			$m = new article_cate;
			$info = $m->FindData();
			$list = $m->SelectTreeData();
			view::assign('list',$list);
			view::assign('info',$info);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function edit(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['pid'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		$m = new article_cate;
		$result = $m->updateData();
  		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	
	public static function del(){
		adminrole::auth();//判断用户权限
		if(isset($_POST['id'])){
			$find =  [
				'id'=>$_POST['id']
			];
			$m = D('article_cate');			
			$edit = $m->where($find)->delete();
			if($edit){
				json(array('status'=> 1,'info'=>'删除成功'));
			}
		}else{
			json(array('status'=> 0,'info'=>'ID错误！'));
		}
	}

}