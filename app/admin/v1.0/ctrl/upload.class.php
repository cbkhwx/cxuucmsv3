<?php
namespace ctrl;

use \middleware\adminrole;
use model\attments;
class upload
{
	static function init(){
		$check = new \middleware\check();
		$check->check();
	}
		
	static function imgUpload(){
		adminrole::auth();//判断用户权限
		$up = new \ext\upload();
		$date = date('Ym',time());
		$time = date('d',time());
		$up->set('path', P_PUBLIC . 'uploads/img/'.$date.'/'.$time);        //定义文件上传路径
		$up->set('allowType', ['.jpg', '.gif', '.png', '.jpeg']);   //定义允许上传的文件后缀
		$up->set('maxSize', 2*1024*1024);               //定义允许上传的最大尺寸
		$result = $up->upload();                      //执行上传
		$info = $up->getInfo();                       //返回上传文件信息，索引数组
		$err = $up->getError();                       //返回错误信息，数组
		if($info){
		   json(array('result' => $info,'status'=> 1,'info'=>'上传成功'));
		}else{
		   json(array('result' => $err,'status'=> 0,'info'=>'上传失败'));
		}
	}
	
	static function attmentUpload(){
		adminrole::auth();//判断用户权限
		$up = new \ext\upload();
		$date = date('Ym',time());
		$time = date('d',time());
		$up->set('path', P_PUBLIC . 'uploads/attment/'.$date.'/'.$time);        //定义文件上传路径
		$up->set('allowType', ['.doc', '.xls', '.xlsx', '.docx', '.rar', '.7z', '.txt','zip']);   //定义允许上传的文件后缀
		$up->set('maxSize', 2*1024*1024);               //定义允许上传的最大尺寸
		$result = $up->upload();                      //执行上传
		$info = $up->getInfo();                       //返回上传文件信息，索引数组
												/* 		name        //文件名
														suffix      //后缀名
														originName  //原始文件名
														type        //文件类型
														size        //文件大小【Byte】
														path        //文件的绝对路径
														src         //文件的相对路径 */
		$err = $up->getError();                       //返回错误信息，数组
		
		$m = new attments;					//写入数据库，返回主键
		$prekey = $m->insertData($info[0]['src'],$info[0]['originName'],$info[0]['suffix'],$info[0]['size']);
		
		if($info){
			json(array('result' => $info,'status'=> 1,'info'=>'上传成功','prekey'=>$prekey));
		}else{
			json(array('result' => $err,'status'=> 0,'info'=>'上传失败'));
		}
	}
	
/* 	static function otherUpload(){  //未调用
		adminrole::auth();//判断用户权限
	    $up = new \ext\upload();
	    $date = date('Ym',time());
	    $time = date('d',time());
	    $up->set('path', P_PUBLIC . 'uploads/other/'.$date.'/'.$time);        //定义文件上传路径
	    $up->set('allowType', ['.jpg', '.gif', '.png', '.jpeg']);   //定义允许上传的文件后缀
	    $up->set('maxSize', 2*1024*1024);               //定义允许上传的最大尺寸
	    $result = $up->upload();                      //执行上传
	    $info = $up->getInfo();                       //返回上传文件信息，索引数组
	    $err = $up->getError();                       //返回错误信息，数组
	    if($info){
		    json(array('result' => $info,'status'=> 1,'info'=>'上传成功'));
	    }else{
		    json(array('result' => $err,'status'=> 0,'info'=>'上传失败'));
	    }
	} */
	
	static function tinymceUpload(){
		adminrole::auth();//判断用户权限
	    $up = new \ext\upload();
	    $date = date('Ym',time());
	    $time = date('d',time());
	    $up->set('path', P_PUBLIC . 'uploads/img/'.$date.'/'.$time);        //定义文件上传路径
	    $up->set('allowType', ['.jpg', '.gif', '.png', '.jpeg']);   //定义允许上传的文件后缀
	    $up->set('maxSize', 2*1024*1024);               //定义允许上传的最大尺寸
	    $result = $up->upload();                      //执行上传
	    $info = $up->getInfo();                       //返回上传文件信息，索引数组		//"result":[{"name":"5e4f4e423b3610.jpg","suffix":"jpg","originName":"92532836.jpg","type":"image/jpeg","size":272594,"path":"D:/PHP/htdocs/Z-PHP/public_html/public/uploads/img/5e4f4e423b3610.jpg","src":"/public/uploads/img/5e4f4e423b3610.jpg"}]
	    $err = $up->getError();                       //返回错误信息，数组
	    if($info){
		    json(array('location' => $info[0]['src'],'status'=> 200));
	    }else{
		    json(array('res'=>$err,'status'=> 0));
	    }
	}
}