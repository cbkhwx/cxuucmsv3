# [龙啸轩内容管理系统 V3.1](http://www.cxuu.top)

此版本是基于 Z-PHP 和 layui构建，简单高效！！简单粗暴！！
适合公司企业站、企事业单位CMS站、新闻站、单位或公司内网站点，并可以根据实际需要二次开发微信、API接口等。

目前，本系统已经过部分案例上线测试，可放心使用！

# 前端：

1、支持页面数据定制灵活调用；

2、视图页静态化；

3、Redis\memcache\file文件缓存，可以自由定制缓存时间；

4、前端包括：文章、图集、公司成员显示、值班安排、访问统计（异步加载数据，每次访问不会直接写入数据库，会写入Redis缓存，达到条件后再写入数据库）等；

5、灵活路由方式；

6、独立搜索模块；

7、以及一些未描述功能。

# 后台：

1、灵活角色、管理员权限；

2、后台菜单灵活定制；

3、JSON数据列表；

4、便捷的栏目管理；

5、系统公告；

6、系统设置；

7、缓存管理；

8、扩展功能包括：访问图形化显示、值班安排管理、图集管理、内部成员管理等；

9、其它功能。


# 环境需求：

- php 7.1+ (开发环境测试了7.1 7.2 7.3 7.4 建议7.4)

- mysql 5.6+ （开发环境用的是MariaDB 10.2）

- Aapache\Nginx\IIS等（前台部分配置文件里'URL_MOD' => 2, 开启路由模式下需要环境Rewrite，后台默认不需要开启Rewrite）

- Redis（非必须，但强烈建议使用）


# 开发文档：

系统采用PHP框架和UI框架非浸入式编写，可完全参照框架文档进行二次开发
# [Z-PHP框架](http://www.z-php.com)
[文档](https://www.showdoc.cc/zphp4):https://www.showdoc.cc/zphp4



# CXUUCMS V3使用文档：

##### 本系统使用比较简单，在程序内部和模板上都有相应注释。

这里主要说明一些较常用的前台使用方法，后台部分有特别使用的地方均做了相应提示，在使用上不会存在障碍！

- 前端一般采用php原生写法，也可以参照框架前端文档用框架约定方式输出，两者在性能上没有区别，只是个人习惯而已。

        一、内容列表前端调用方法：
		  <?php foreach(\model\article::selectData('3,6',5,60,1,3) as $v){
			 	echo $v['title']; //标题
			 	echo $v['title']; //标题
				echo urlInfo($vo['id']);　//按照路由模式生成相应的 链接地址
				echo fTime($vo['time'],'m-d'); //生成格式化时间
				..........
			  
		  }?> 
		  关于 selectData('3,6',5,60,1,3) 说明：
		  1、CID单个栏目直接填写数据 如： 2 ，多个栏目："3,6,5" 或 0全部栏目;
		  2、条数 支持偏移如："2,10";
		  3、缓存时间 600单位秒; 
		  4、是否图片 1; 
		  5、是否头条 1 或小头条 2 或 图片轮换 3;

		二、值班安排调用（可根据实际使用场景自定义）

		<?php $ondutyInfo = \model\ondutys::findData(); ?>  //在当前模板中获取到模型变量

			今日(<?php echo $ondutyInfo['ondutytime'];?>) 值班 - 
			公司领导：<b> <?php echo $ondutyInfo['juname'];?></b>
			部门领导：<b> <?php echo $ondutyInfo['chuname'];?></b>
			值班员：<b> <?php echo $ondutyInfo['yuanname'];?></b>


		三、路由模式下的链接生成方法
		  1、echo urlInfo($vo['id']);  生成内容页链接
		  2、echo urlList($vo['id']);  生成列表页链接
		  2、echo urlImage($vo['id']);  生成图集内容页链接

		四、截取字符长度
		  echo cxuuMbStr($vo['title'],20);
		  
		五、格式化时间显示
		  1、显示多久以前   echo historyTime($info['time']);
		  2、格式化时间     echo fTime($vo['time'],'Y-m-d');
		
		六、图集调用方法
		<?php foreach((array)\model\images::selectData() as $vo){?>
			<li>
				<div class="pic"><a href="<?php echo urlImage($vo['id']);?>" target="_blank"><img src="<?php echo $vo['img'];?>" /></a></div>
				<div class="title"><a href="<?php echo urlImage($vo['id']);?>" target="_blank"><?php echo cxuuMbStr($vo['title'],22);?></a></div>
			</li>
		<?php }?>

		七、分页
		分页通过从继承模板中调用分页方法，实例使用中可以自由定制/index/v1.0/view/default/block/common.html 是存在常用模板的文件：
		<div id="page">
			<div class="manu">
				<?php if($page['prev'] != "javascript:;"){?><a href="<{$page['first']}>">头页 </a><?php }?>
				<?php if($page['prev'] != "javascript:;"){?><span><a href="<{$page['prev']}>">&lt;</a></span><?php }?>
				<?php foreach($page['list'] as $key=>$vo){ ?>
				<?php if($vo != "javascript:;"){?><span class="disabled"><a href="<{$vo}>"><{$key}></a></span>
				<?php }else{ ?><span class="current"><a href="<?php echo $vo;?>"><?php echo $key;?></a></span><?php } ?>
				<?php }?>
				<?php if($page['next'] != "javascript:;"){?><span><a href="<{$page['next']}>">&gt; </a></span><?php }?>
				<?php if($page['last'] != "javascript:;"){?><span><a href="<{$page['last']}>">末页 </a></span><?php }?>
			</div>
		</div>
		调用方法，在列表页加入以下这段代码即可：
		<import file="block/common.html" name="page"/>

		八：系统配置调用，如：
		<?php echo siteInfo('copyright');?>//版权信息
		<title><?php echo siteInfo('sitename');?></title>//网站名称
		<meta name="keywords" content="<?php echo siteInfo('keywords');?>">
		<meta name="description" content="<?php echo siteInfo('descript');?>">


		九、访问统计

		html:
		本站访问统计（PV值 缓存10分钟更新）- 今日访问：<span class="visit_today"></span> 
		昨日：<span class="visit_yesterday"></span> 
		总访问：<span class="visit_sum"></span> 
		最高日访问：<span class="visit_max"></span>

		jq:
		$.getJSON('/visit', {}, function (data) {
			$('.visit_today').text(data['today']);
			$('.visit_yesterday').text(data['yesterday']);
			$('.visit_sum').text(data['sum']);
			$('.visit_max').text(data['max']);
		})

        十、成员显示及其它用法可参考现有模板示例


- 后台访问地址：xxx.com/admin.php
- 后台用户名：admin  密码：123456

# 数据库
- 数据库是根目录的cxuuweb.sql，直接导入数据库即可，数据库配置文件在根目录的common/config.php里！

### 目录绑定

- WEB目录请绑定在：/public
- 暂时不支持网站子目录绑定，下步将解决这个问题（很多地方使用了绝对路径）

# 特别注意：

1、前端默认开启了redis缓存及路由模式，需要运行环境支持！也可以通过config.php 配置使用文件缓存或者 MEMCACHE缓存；

2、网站要要求环境伪静态支持！

3、建议使用Redis 本系统主要基于此缓存环境中优化，个别地方主要依赖于Redis 如访问统计部分。

4、开发环境是在WINDOWS下进行的，后台的缓存管理功能，涉及文件系统部分没有严格测试，可能在非WIN系统下会有读取不到文件大小的问题，下步会解决！

# 演示

- 演示站点正在备案，很快就可以开放！！http://www.cxuu.top/

