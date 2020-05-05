<?php
namespace ctrl;

use \middleware\adminrole;
use model\article;
use model\article_cate;
use model\siteconfig;
use z\view;

class content
{
	static function init(){
		$check = new \middleware\check();
		$check->check();
	}
	
    public static function index()
    {
		adminrole::auth();//判断用户权限
		if(isset($_GET['cid'])){
				$cid = $_GET['cid'];
			}else{
				$cid = '';
			}
		view::assign('cid',$cid);
		view::display();
    }
	
	public static function addview(){
		adminrole::auth();
		//获取栏目数据
		$m = new article_cate;
		$cateListTree = $m->SelectTreeData();
		//获取上传类型
		$d = new siteconfig;
		$uploadattext = $d->getUploadAttmentSwitch();
		$uploadimgext = $d->getUploadImageSwitch();
		view::assign('uploadattext',$uploadattext);
		view::assign('uploadimgext',$uploadimgext);
		view::assign('list',$cateListTree);
		view::display();
	}
	
	public static function add(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['title'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		$m = new article;
		$result = $m->insertData();
  		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg'],'cid' => $result['cid']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	public static function editview(){
		adminrole::auth();//判断用户权限
		if(isset($_GET['id'])){
			//获取当前ID的一条内容信息
			$m = new article;
			$info = $m->findData();
			
			//获取栏目树形数据
			$catelist = new article_cate;
			$cateListTree = $catelist->SelectTreeData();
			//获取上传类型
			$d = new siteconfig;
			$uploadattext = $d->getUploadAttmentSwitch();
			$uploadimgext = $d->getUploadImageSwitch();
			view::assign('uploadattext',$uploadattext);
			view::assign('uploadimgext',$uploadimgext);

			view::assign('list',$cateListTree);
			view::assign('info',$info);
			view::display();
		}else{
			return '缺少参数:id';
		}
	}
	
	public static function edit(){
		adminrole::auth();//判断用户权限
		if(!isset($_POST['title'])){
			json(array('status'=> 0,'info'=>'请填写必填数据！'));
		}
		if(!isset($_POST['id'])){
			json(array('status'=> 0,'info'=>'未知ID！'));
		}
		
		$m = new article;
		$result = $m->updateData();
		if($result['status']){
			json(array('status'=> $result['status'],'info'=>$result['msg'],'cid' => $result['cid']));
		}else{
			json(array('status'=> $result['status'],'info'=>$result['msg']));
		}
	}
	
	public static function switchStatus(){
		adminrole::auth();//判断用户权限
		if(isset($_POST['id'])){
			$m = new article;			
			$edit = $m->switchStatus();
			if($edit){
				json(array('status'=> 1,'info'=>'设置成功'));
			}
		}else{
			json(array('status'=> 0,'info'=>'ID错误！'));
		}
	}
	
	public static function del(){
		adminrole::auth();//判断用户权限
		if(isset($_POST['id'])){
			$m = new article;
			$del = $m->deleteOneData();
			if($del){
				json(array('status'=> 1,'info'=>'删除成功'));
			}
		}else{
			json(array('status'=> 0,'info'=>'ID错误！'));
		}
	}
	
	
	
	//内容列表JSON列表
	public static function jsonlist()
	{
		adminrole::auth();
		$d = new article;
		$result = $d->jsonPageSelect();
		$jsonlist = array();
		$jsonlist['code'] = 0;
		$jsonlist['msg'] = 'ok';
		$jsonlist['count'] = $result['page']['rows'];
		$jsonlist['data'] = $result['data'];
		exit(json_encode($jsonlist));
	}
	
	//栏目分类列表展示
	//左侧菜单调用
	public static function cateTreeJsonlist(){
		adminrole::auth();
		$db = new article_cate;
		$result = $db->jsonSelectData();
		$jsonlist['code'] = 0;
		$jsonlist['msg'] = '操作成功';
		$jsonlist['data'] = contentCateTree($result);
		exit(json_encode($jsonlist));
	}
}
