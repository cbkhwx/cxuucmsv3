<?php
const CXUUCMS_V="cxuucms V3.1";
/* 
 *  获取 $_SESSION 值
 *  参照login.class.php 的登录方法调用相应数据
 *  使用方法：在模板<?php echo sessionInfo("nickname");?> 
 */
function sessionInfo($val){
	$sessionInfo = $_SESSION['cxuu_admin'][$val];
	return $sessionInfo;
}

/* 
 *  对比数组是否有指定值
 *  返回 checkbox 选定状态
 *  使用方法：用于系统权限设置页<?php echo systemroleInarray("siteconfig_index",$systemrole);?>
 */
function systemroleInarray($val,$arr){
	$sessionInfo = in_array($val,$arr)?'checked':'';
	return $sessionInfo;
}

/* 
 *  获取系统拥有的栏目权限
 */
function channlrole(){
	$channlrole = unserialize(sessionInfo("channlrole"));
	$channlid = implode(",",$channlrole);
	return $channlid;
}
/* 
 *  获取系统拥有的后台菜单权限
 */
function adminMenuRole(){
	$menurole = unserialize(sessionInfo("menurole"));
	$menuroleid = implode(",",$menurole);
	return $menuroleid;
}
/* 
 *  显示拥有的系统功能权限
 $val 为权限值，如： articlecontent_addview
 */
function sysrolTF($val){
	if(sessionInfo("gid")!=1){
		$val = strtolower($val);
		$systemrole = unserialize(sessionInfo("systemrole"));
		$basepurview = array_map('strtolower', $systemrole);//转换成小写
		//$systemroleArr = implode(",",$basepurview);
		$tr = in_array($val,$basepurview)?true:false;
		return $tr;
	}else{
		return true;
	}
}

 
/* 
 *  拓展Redis 缓存清除方法
 *  =================================
 *	$key 删除指定ID 否则清空全部
 *  
 */
function RCD($key=null){
	z\cache::Redis();
	$c = z\cache::Redis();
	if(null !== $data){
		$result = $c->delete($key);
	}else{
		$result = $c->flushAll();
	}
	return $result;
}
	
/* 
 *  拓展Redis 获取全部key 计算有多少条 缓存数据
 *  =================================
 *	$c->keys('*') 全部KEY
 *  
 */
function RCA(){
	z\cache::Redis();
	$c = z\cache::Redis();
	$result = $c->keys('*');
	$count = count($result);
	return $count;
}

/* 
 *  后台系统菜单
 *  =================================
 *	引用方式实现无限极分类
 *  使用方法：generateTree($data)
 */
function generateTree($data){
    $items = array();
    foreach($data as $v){
        $items[$v['id']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){
        if(isset($items[$item['pid']])){
            $items[$item['pid']]['haveChild'] = true;
            $items[$item['pid']]['href'] = true;
            $items[$item['pid']]['open'] = true;
            $items[$item['pid']]['children'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return $tree;
}


/* 
 *  后台 内容管理 栏目分类菜单
 *  =================================
 *	引用方式实现无限极分类
 *  使用方法：contentCateTree($data)
 */
function contentCateTree($data){
	$dataRename = array();
	foreach($data as $key=>$newdata){
		$dataRename[$key]['id'] = $data[$key]['id'];
		$dataRename[$key]['parentId'] = $data[$key]['pid'];
		$dataRename[$key]['title'] = $data[$key]['name'];
		$dataRename[$key]['checkArr'] = ["type"=>"0", "checked"=>"0"];
		$dataRename[$key]['type'] = $data[$key]['type'];
		$dataRename[$key]['theme'] = $data[$key]['theme'];
	}

    $items = array();
    foreach($dataRename as $v){
        $items[$v['id']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){
        if(isset($items[$item['parentId']])){
            $items[$item['parentId']]['children'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return $tree;
}

/* 
 *  后台 菜单分类菜单
 *  =================================
 *	引用方式实现无限极分类 
 *  使用方法：menuCateTree($data)
 */
function menuCateTree($data){
	$dataRename = array();
	foreach($data as $key=>$newdata){
		$dataRename[$key]['id'] = $data[$key]['id'];
		$dataRename[$key]['parentId'] = $data[$key]['pid'];
		$dataRename[$key]['title'] = $data[$key]['name'];
		$dataRename[$key]['checkArr'] = ["type"=>"0", "checked"=>"0"];
	}

    $items = array();
    foreach($dataRename as $v){
        $items[$v['id']] = $v;
    }
    $tree = array();
    foreach($items as $k => $item){
        if(isset($items[$item['parentId']])){
            $items[$item['parentId']]['children'][] = &$items[$k];
        }else{
            $tree[] = &$items[$k];
        }
    }
    return $tree;
}

/* 
 *  递归方式实现无限极分类
 *  使用方法：getTree($data)
 */
function getTree($arr,$pid=0,$level=0)
{
    static $list = [];
    foreach ($arr as $key => $value) {
        if ($value["pid"] == $pid) {
            $value["level"] = $level;
            $value["open"] = true;
            $list[] = $value;
            unset($arr[$key]); //删除已经排好的数据为了减少遍历的次数
            getTree($arr,$value["id"],$level+1);
        }
    }
    return $list;
}

/** 
 统计目录文件大小的函数 
 @author xfcode 
*/
function dirSize($dir){
	$size=0;
	//打开目录
	$dd=@opendir($dir);  		//--opendir("")打开一个目录，返回此目录的资源句柄
	@readdir($dd); 				//--通过读两次，来跳过特殊目录"."、".."
	@readdir($dd);
	//遍历目录累加大小
	while($f = @readdir($dd)){ 	//--readdir(资源句柄)从目中读取一个目录或文件，并指针向下移动一位。
		$file = $dir."/".$f; 	//--为文件名添加目录名
		if(is_file($file)){
			$size += filesize($file);
		}
		if(is_dir($file)){
			$size +=dirSize($file); //--递归调用
		}
	}
	//关闭目录
	@closedir($dd);				//--closedir(资源句柄)关闭打开的目录
	return $size;
}

/**
 * 删除目录及文件
 * @param  [type]  $dirName [description]
 * @param  boolean $t       [是否删除目录]
 * @param  integer $i       [description]
 * @return integer          [删除的文件数]
 */
function del_dir($dirName,$t=true,$i=0){
	if($handle = opendir($dirName)){
		while(false !== ($item = readdir($handle))){
			if ($item != "." && $item != ".."){
				if(is_dir($dirName.'/'.$item)){
					$ii=del_dir($dirName.'/'.$item,$t);
					$i+=$ii;
				}elseif(unlink($dirName.'/'.$item)) $i++;
			}
		}
		closedir($handle);			
	}else return false;
	$t && rmdir($dirName);
	return $i;
}


//加密函数，可用cp_decode()函数解密，$data：待加密的字符串或数组；$key：密钥；$expire 过期时间
function cp_encode($data,$key='',$expire = 0)
{
	$string=serialize($data);
	$ckey_length = 4;
	$key = md5($key);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = substr(md5(microtime()), -$ckey_length);

	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	
	$string =  sprintf('%010d', $expire ? $expire + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) 
	{
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) 
	{
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) 
	{
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	return $keyc.str_replace('=', '', base64_encode($result));		
}
//cp_encode之后的解密函数，$string待解密的字符串，$key，密钥
function cp_decode($string,$key='')
{
	$ckey_length = 4;
	$key = md5($key);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = substr($string, 0, $ckey_length);
	
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	
	$string =  base64_decode(substr($string, $ckey_length));
	$string_length = strlen($string);
	
	$result = '';
	$box = range(0, 255);

	$rndkey = array();
	for($i = 0; $i <= 255; $i++) 
	{
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}

	for($j = $i = 0; $i < 256; $i++) 
	{
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}

	for($a = $j = $i = 0; $i < $string_length; $i++) 
	{
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
		return unserialize(substr($result, 26));
	}
	else
	{
		return '';
	}	
}
