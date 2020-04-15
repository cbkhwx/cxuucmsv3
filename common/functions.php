<?php

/**
 * 输出json格式数据（脚本中断）
 * @param  [type] $data [description]
 * @return [type]       [description]
 */
function json($data=null){
	header('Content-Type:application/json; charset=utf-8');
	die(json_encode($data,JSON_UNESCAPED_UNICODE));
}


/**
* 页面跳转
* @param  [type] $url [description]
* @return [type]      [description]
*/
function redirect($url=null){
	header("Content-type: text/html; charset=utf-8");
	header("Location:" . $url);
	die;
}

/**
 * 操作cookie
 * @param  [type]  $key   [description]
 * @param  string $value [description]
 * @param  integer $time  [description]
 * @param  string  $path  [description]
 * @return [type]         [description]
 */
function cookie(){
	$args = func_get_args();
	if(isset($args[1])){
		$time = empty($args[2]) ? ($_COOKIE['InvalidTime'] ?? 0) : NOW_TIME + $args[2];
		$path = $args[3] ?? '/';
		setcookie('InvalidTime',$time,$time,$path);
		return setMyCookie($args[0],$args[1],$time,$path);
	}else{
		if(!isset($_COOKIE[$args[0]])) return null;
		return $_COOKIE[$args[0]];
	}
}
function setMyCookie($key,$value,$time,$path,$i=0){
	if(!is_array($value)){
		if(setcookie($key,$value,$time,$path)) $i++;
	}else{
		foreach($value as $k=>$v){
			setMyCookie("{$key}[$k]",$v,$time,$path,$i);
		}
	}
	return $i;
}

/**
 * 格式化显示时间
 * $t DateTime
 * $f Y/m/d H:i:s
 * 使用方法：在模板<?php echo cxuuMbStr($vo['title']);?> 
 * */
function fTime($t,$f)
{
	$date=date_create($t);
	$ftime =  date_format($date,$f);
    return $ftime;
}


/**
 * 是否是关联数组
 * @param  [type]  $arr [description]
 * @return boolean      [description]
 */
function is_assoc($arr){
	return !is_numeric(implode('',array_keys($arr)));
}

/**
 * 是否是索引数组
 * @param  [type]  $arr [description]
 * @param  [type]  $r   下标是否是从0开始的连续数字
 * @return boolean      [description]
 */
function is_index($arr,$r=false){
	$str = implode('',array_keys($arr));
	return is_numeric($str) ? ($r ? $str == implode('',range(0,count($arr) - 1)) : true) : talse;
}

/**
* 文件大小格式化
* @param integer $size 初始文件大小，单位为byte
* @return array 格式化后的文件大小和单位数组，单位为byte、KB、MB、GB、TB
*/
function file_size_format($size=0,$dec=2){
	$unit = ['B','KB','MB','GB','TB','PB'];
	$pos = 0;
	while($size >= 1024){
		$size /= 1024;
		$pos++;
	}
	return round($size,$dec) . $unit[$pos];
}

/**
 * 压缩html文本（去除注释多余的空格制表符及换行符，如果文本存在js代码请谨慎使用）
 * @param  [type] $string [description]
 * @return [type]         [description]
 */
function compress_html($string){
	return trim(preg_replace(['/<!--[^\!\[]*?-->/','/[\\n\\r\\t]+/','/\\s{2,}/','/>\\s</','/\\/\\*.*?\\*\\//i'],['',' ',' ','><',''],$string)); 
}

/**
 * Unicode编码转换
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function decodeUnicode($str){
	return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
	create_function(
		'$matches',
		'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'
	),
	$str);
}

/**
 * 获取客户端ip地址
 * @return string
 */
function getip(){
	$ip=false;
	empty($_SERVER['HTTP_CLIENT_IP']) || $ip = $_SERVER['HTTP_CLIENT_IP'];
	if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ips = explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
		if($ip){
			array_unshift($ips,$ip);
			$ip = false;
		}
		$count = count($ips);
		for($i=0;$i!=$count;$i++) {
			if(!preg_match('/^(10│172.16│192.168)./',$ips[$i])){
				$ip = $ips[$i];
				break;
			}
		}
	}
	return $ip ?: $_SERVER['REMOTE_ADDR'];
}

/**
 * 判断是否是绝对路径
 * @param  $path string 路径
 * @return boolean
 */
function true_path($path){
	if(0 === stripos(PHP_OS,'WIN')) return ':' == substr($path,1,1);
	else return '/' == substr($path,0,1);
}

/**
 * 时间转化为多久前
 * @param  $date datetime 时间
 * @return date('Y-m-d H:i:s',time());
 */
 
function historyTime($date){
		$time = strtotime($date);
        $time = time() - $time;
        if(is_numeric($time)){  
            $value = array(  
                  "years" => 0, "days" => 0, "hours" => 0,  
                  "minutes" => 0, "seconds" => 0,  
            );  
            if($time >= 31556926){  
                  $value["years"] = floor($time/31556926);  
                  $time = ($time%31556926);
                  $t = $value["years"].'年前';  
            }  
            elseif(31556926 >$time && $time >= 86400){  
                 $value["days"] = floor($time/86400);  
                  $time = ($time%86400);
                  $t = $value["days"].'天前';  
            }  
            elseif(86400 > $time && $time >= 3600){  
                 $value["hours"] = floor($time/3600);  
                  $time = ($time%3600);
                  $t = $value["hours"].'小时前';  
            }  
            elseif(3600 > $time && $time >= 60){  
                  $value["minutes"] = floor($time/60);  
                  $time = ($time%60);
                  $t = $value["minutes"].'分钟前';  
            }else{
                $t = $time.'秒前';
            }   
            return $t;    
        }else{  
            return date('Y-m-d H:i:s',time());  
        }  
    }
