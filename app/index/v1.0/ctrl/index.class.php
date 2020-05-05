<?php
namespace ctrl;

use model\siteconfig;
use z\view;

class index
{
	static function init(){
		\model\visits::insertData();//用户访问记录 写入记数
	}
	
    public static function index()
    {
		$d = new siteconfig;
		$swtich = $d->getCacheConfig('indexhtml');
		if($swtich ==1){
			$time = $d->getCacheConfig('indexhtmltime');
			$html = view::GetCache($time, 'index.html');
			if($html){
				echo $html;
			}else{
				view::Display();
			}
		}else{
			view::Display();
		}
    }
}
