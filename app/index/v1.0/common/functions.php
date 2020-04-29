<?php



/* 
 *  获取网站系统配置信息方法
 *  使用方法：在模板<?php echo urgetSiteConfiglInfo($vo['id']);?> 
 */
function siteInfo($key){
	$info = \model\siteconfig::getSiteConfig($key);
	return $info;
}
/* 
 *  路由 图集内容页 URL 生成方法
 *  使用方法：在模板<?php echo urlImage($vo['id']);?> 
 */
function urlImage($val){
	$routeMod = $GLOBALS['ZPHP_CONFIG']['URL_MOD'];
	switch($routeMod){
		case 0:
			$url = "/?c=image&a=index&id=".$val;
			break;
		case 1:
			$url = "/image/index/id/".$val;
			break;
		case 2:
			$url = "/image/".$val;
			break;
	}
	return $url;
}

/* 
 *  路由 内容页 URL 生成方法
 *  使用方法：在模板<?php echo urlInfo($vo['id']);?> 
 */
function urlInfo($val){
	$routeMod = $GLOBALS['ZPHP_CONFIG']['URL_MOD'];
	switch($routeMod){
		case 0:
			$url = "/?c=content&a=index&id=".$val;
			break;
		case 1:
			$url = "/content/index/id/".$val;
			break;
		case 2:
			$url = "/info/".$val;
			break;
	}
	return $url;
}


/* 
 *  路由 列表页 URL 生成方法
 *  使用方法：在模板<?php echo urlList($vo['id']);?> 
 */
function urlList($val){
	$routeMod = $GLOBALS['ZPHP_CONFIG']['URL_MOD'];
	switch($routeMod){
		case 0:
			$url = "/?c=contents&a=index&cid=".$val;
			break;
		case 1:
			$url = "/contents/index/cid/".$val;
			break;
		case 2:
			$url = "/list/".$val;
			break;
	}
	return $url;
}


/* 
 *  utf-8中文截取，单字节截取模式   暂时未使用这种方式
 *  使用方法：在模板<?php echo cxuuSubstr($vo['title']);?> 
 */

function cxuuSubstr($str,$length,$append='..',$start=0){ 
  if(strlen($str)<$start+1){ 
    return ''; 
  } 
  preg_match_all("/./su",$str,$ar); 
  $str2=''; 
  $tstr=''; 

  for($i=0;isset($ar[0][$i]);$i++){ 
    if(strlen($tstr)<$start){ 
      $tstr.=$ar[0][$i]; 
    }else{ 
      if(strlen($str2)<$length + strlen($ar[0][$i])){ 
        $str2.=$ar[0][$i]; 
      }else{ 
        break; 
      } 
    } 
  } 
  return $str==$str2?$str2:$str2.$append; 
}

/**
 * 截取字符
 * $title string
 * $end   number
 * 使用方法：在模板<?php echo cxuuMbStr($vo['title']);?> 
 * */
function cxuuMbStr($title, $end)
{
    if (mb_strlen($title, 'utf8') > $end -= 0) {
        $tit = mb_substr($title, 0, $end, 'utf8') . "..";
    } else {
        $tit = $title;
    }
    return $tit;
}


/*  
 * 根据二维数组某个字段的值查找数组
 
	$arr = array( 
		0=>array( 
		        'id'=>1, 
		        'name'=>'a' 
		), 
		.... 
		3=>array( 
		        'id'=>4, 
		        'name'=>'d' 
		), 
	); 
	* $res = filter_by_value($arr,'name','d'); 
	* $result['name'] = array_column($find,'name');
	* $result['theme'] = array_column($find,'theme');
	最终输出：
	array(2) {
	  ["name"] =>array(1) {
		[0] =>string(12) "电子产品"
	  }
	  ["theme"] =>array(1) {
		[0] =>string(0) ""
	  }
	}
 */  
function filter_by_value($array, $index, $value){  
    if(is_array($array) && count($array)>0)  
   { 
       foreach(array_keys($array) as $key){  
            $temp[$key] = $array[$key][$index];  
            if ($temp[$key] == $value){ 
               $newarray[$key] = $array[$key];  
            }  
       }
   }  
  return $newarray;  
}

