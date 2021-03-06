-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        10.4.12-MariaDB - mariadb.org binary distribution
-- 服务器OS:                        Win64
-- HeidiSQL 版本:                  10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table cxuuweb.cxuu_admin_group
CREATE TABLE IF NOT EXISTS `cxuu_admin_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(50) DEFAULT NULL,
  `systemrole` text DEFAULT NULL,
  `channlrole` text DEFAULT NULL,
  `menurole` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_admin_group: 5 rows
/*!40000 ALTER TABLE `cxuu_admin_group` DISABLE KEYS */;
INSERT INTO `cxuu_admin_group` (`id`, `groupname`, `systemrole`, `channlrole`, `menurole`) VALUES
	(1, '超级管理员', 'a:5:{i:0;s:11:"index_index";i:4;s:11:"cache_index";i:18;s:12:"notice_index";i:42;s:16:"admingroup_index";i:53;s:15:"adminuser_index";}', 'a:8:{i:0;s:1:"5";i:1;s:1:"8";i:2;s:1:"6";i:3;s:1:"1";i:4;s:1:"2";i:5;s:1:"7";i:6;s:1:"4";i:7;s:1:"3";}', NULL),
	(2, '内容管理员', 'a:10:{i:0;s:11:"index_index";i:1;s:10:"index_home";i:33;s:13:"content_index";i:34;s:16:"content_jsonlist";i:35;s:24:"content_cateTreeJsonlist";i:36;s:15:"content_addview";i:37;s:11:"content_add";i:38;s:16:"content_editview";i:39;s:12:"content_edit";i:40;s:11:"content_del";}', 'a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"5";i:4;s:1:"6";}', 'a:2:{i:0;s:2:"12";i:1;s:2:"13";}'),
	(3, '政治部', 'a:16:{i:0;s:11:"index_index";i:1;s:10:"index_home";i:4;s:11:"cache_index";i:6;s:18:"cache_delFileCache";i:18;s:12:"notice_index";i:19;s:15:"notice_jsonlist";i:20;s:14:"notice_addview";i:22;s:15:"notice_editview";i:42;s:16:"admingroup_index";i:43;s:19:"admingroup_jsonlist";i:44;s:18:"admingroup_addview";i:46;s:19:"admingroup_editview";i:53;s:15:"adminuser_index";i:54;s:18:"adminuser_jsonlist";i:55;s:17:"adminuser_addview";i:57;s:18:"adminuser_editview";}', 'a:6:{i:0;s:1:"5";i:1;s:1:"8";i:2;s:1:"6";i:3;s:1:"1";i:4;s:1:"2";i:5;s:1:"3";}', 'a:3:{i:0;s:2:"14";i:1;s:2:"15";i:2;s:2:"11";}'),
	(4, '政治部', 'N;', 'a:2:{i:0;s:1:"5";i:1;s:1:"6";}', 'a:3:{i:0;s:2:"14";i:1;s:2:"15";i:2;s:2:"11";}'),
	(6, '司令部1', 'a:2:{i:0;s:11:"index_index";i:1;s:10:"index_home";}', 'a:8:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"3";i:3;s:1:"4";i:4;s:1:"7";i:5;s:1:"9";i:6;s:1:"5";i:7;s:1:"8";}', 'a:11:{i:0;s:2:"12";i:1;s:2:"13";i:2;s:2:"14";i:3;s:2:"15";i:4;s:1:"5";i:5;s:2:"16";i:6;s:1:"4";i:7;s:1:"3";i:8;s:1:"1";i:9;s:1:"2";i:10;s:1:"9";}');
/*!40000 ALTER TABLE `cxuu_admin_group` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_admin_menu
CREATE TABLE IF NOT EXISTS `cxuu_admin_menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `controller` varchar(50) DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `ico` varchar(100) DEFAULT NULL,
  `sort` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_admin_menu: 20 rows
/*!40000 ALTER TABLE `cxuu_admin_menu` DISABLE KEYS */;
INSERT INTO `cxuu_admin_menu` (`id`, `pid`, `name`, `controller`, `action`, `ico`, `sort`) VALUES
	(1, 4, '缓存管理', 'cache', 'index', 'layui-icon-theme', 2),
	(2, 4, '系统设置', 'system', 'index', 'layui-icon-set', 3),
	(3, 4, '系统公告', 'notice', 'index', 'layui-icon-notice', 1),
	(4, 0, '系统管理', 'menu', 'system', 'layui-icon-app', 4),
	(5, 0, '管理员管理', 'menu', 'adminuser', 'layui-icon-username', 3),
	(6, 5, '管理员列表', 'adminuser', 'index', 'layui-icon-vercode', 1),
	(7, 5, '角色列表', 'admingroup', 'index', 'layui-icon-home', 3),
	(9, 4, '系统菜单', 'systemmenu', 'index', 'layui-icon-templeate-1', 4),
	(11, 14, '添加栏目', 'contentcate', 'addview', 'layui-icon-senior', 2),
	(12, 0, '文章内容', 'menu', 'content', 'layui-icon-tabs', 1),
	(13, 12, '全部内容', 'content', 'index', 'layui-icon-password', 1),
	(14, 0, '栏目管理', 'menu', 'channel', 'layui-icon-align-left', 2),
	(15, 14, '栏目列表', 'contentcate', 'index', 'layui-icon-spread-left', 1),
	(16, 5, '添加管理员', 'adminuser', 'addview', 'layui-icon-add-1', 2),
	(17, 5, '添加角色', 'admingroup', 'addview', 'layui-icon-user', 4),
	(18, 0, '扩展功能', 'menu', 'extend', 'layui-icon-util', 6),
	(19, 18, '值班安排', 'onduty', 'index', 'layui-icon-tabs', 1),
	(20, 18, '网站访问量', 'visit', 'index', 'layui-icon-date', 3),
	(21, 18, '图集功能', 'image', 'index', 'layui-icon-picture', 3),
	(22, 18, '领导信息', 'member', 'index', 'layui-icon-user', 4);
/*!40000 ALTER TABLE `cxuu_admin_menu` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_admin_user
CREATE TABLE IF NOT EXISTS `cxuu_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `nickname` varchar(50) DEFAULT NULL,
  `logintime` datetime DEFAULT NULL,
  `loginip` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_admin_user: 4 rows
/*!40000 ALTER TABLE `cxuu_admin_user` DISABLE KEYS */;
INSERT INTO `cxuu_admin_user` (`id`, `gid`, `username`, `password`, `nickname`, `logintime`, `loginip`, `status`) VALUES
	(1, 1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '张三', '2020-05-05 14:22:08', '127.0.0.1', 1),
	(2, 2, 'test', 'e10adc3949ba59abbe56e057f20f883e', 'test', '2020-04-10 12:59:14', '127.0.0.1', 1),
	(3, 1, 'abcdownload', '4124bc0a9335c27f086f24ba207a4912', 'test', NULL, NULL, 1),
	(4, 2, 'test1', 'e10adc3949ba59abbe56e057f20f883e', 'test', NULL, NULL, 1);
/*!40000 ALTER TABLE `cxuu_admin_user` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_article
CREATE TABLE IF NOT EXISTS `cxuu_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL DEFAULT 0,
  `title` varchar(100) DEFAULT NULL,
  `attribute_a` tinyint(1) DEFAULT NULL COMMENT '文章属性 头条',
  `attribute_b` tinyint(1) DEFAULT NULL COMMENT '文章属性 小头条',
  `attribute_c` tinyint(1) DEFAULT NULL COMMENT '文章属性 轮换',
  `attid` int(10) DEFAULT NULL COMMENT '附件地址ID',
  `examine` varchar(10) DEFAULT NULL COMMENT '审核人',
  `img` varchar(100) DEFAULT NULL,
  `imgbl` tinyint(1) NOT NULL DEFAULT 0 COMMENT '判断是否有图片',
  `time` datetime DEFAULT NULL,
  `hits` int(5) DEFAULT 1,
  `status` tinyint(1) DEFAULT NULL,
  `uid` int(5) DEFAULT NULL COMMENT '用户ID',
  `gid` int(5) DEFAULT NULL COMMENT '用户组ID',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_article: 44 rows
/*!40000 ALTER TABLE `cxuu_article` DISABLE KEYS */;
INSERT INTO `cxuu_article` (`id`, `cid`, `title`, `attribute_a`, `attribute_b`, `attribute_c`, `attid`, `examine`, `img`, `imgbl`, `time`, `hits`, `status`, `uid`, `gid`) VALUES
	(1, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, NULL, 0, '2020-02-20 19:11:19', 3, 1, NULL, 0),
	(2, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, NULL, 0, '2020-02-18 18:58:55', 1, 0, NULL, 0),
	(3, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '', 0, '2020-02-21 12:57:39', 3, 1, NULL, 0),
	(4, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, NULL, 0, '2020-02-20 19:26:11', 2, 1, NULL, 0),
	(5, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, NULL, 0, '2020-02-20 19:31:45', 1, 1, NULL, 0),
	(6, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, NULL, 0, '2020-02-20 19:31:57', 2, 1, NULL, 0),
	(7, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, NULL, 0, '2020-02-20 19:32:04', 3, 1, NULL, 0),
	(8, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, NULL, 0, '2020-02-20 19:32:12', 1, 1, NULL, 0),
	(9, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, NULL, 0, '2020-02-20 19:32:22', 1, 1, NULL, 0),
	(10, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, NULL, 0, '2020-02-20 19:32:29', 1, 1, NULL, 0),
	(11, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/21/5e4f638e541a60.jpg', 0, '2020-02-21 12:58:56', 1, 1, NULL, 0),
	(12, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/21/5e4f8c9db98c40.jpg', 0, '2020-03-01 15:26:23', 2, 1, NULL, 0),
	(13, 3, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '', 0, '2020-03-02 15:37:50', 9, 1, NULL, 0),
	(14, 6, '你可以改变下拉树的初始值你可以改变下拉树的初始值你可以改变下拉树的初始值', NULL, NULL, 0, 0, NULL, '', 0, '2020-02-29 19:42:14', 3, 1, NULL, 0),
	(15, 6, '页面中hack一个cdn的html5.js不能使用，但是放到项目中就可以用？', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/25/5e54d326462560.jpg', 0, '2020-02-25 15:56:52', 85, 1, NULL, 0),
	(16, 3, '联播+丨统筹做好经济社会发展工作 习近平的战“疫”方略', NULL, NULL, 0, 0, NULL, '', 0, '2020-04-10 17:02:12', 62, 1, NULL, 0),
	(17, 3, '一男子恶意诋毁西藏疫情防控工作被拉萨公安拘留', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/29/5e5a49a9f13880.jpg', 0, '2020-02-29 19:23:30', 10, 1, NULL, 0),
	(18, 3, '一男子恶意诋毁西藏疫情防控工作被拉萨公安拘留', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/29/5e5a49a9f13880.jpg', 0, '2020-04-03 09:48:09', 23, 1, NULL, 0),
	(19, 3, '管理员管理', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/29/5e5a4a00ef62e0.jpg', 0, '2020-02-29 19:39:46', 4, 1, NULL, 0),
	(20, 3, '管理员管理', NULL, NULL, 0, 0, NULL, '', 0, '2020-03-01 15:24:25', 3, 0, NULL, 0),
	(21, 6, '管理员管理', NULL, NULL, 0, 0, NULL, '', 0, '2020-04-07 09:46:08', 1, 1, NULL, 0),
	(22, 6, '管理员管理', NULL, NULL, 0, 0, NULL, '/uploads/img/202004/07/5e8bd703413c12329870.jpg', 0, '2020-04-07 09:46:34', 1, 1, NULL, 0),
	(39, 6, '龙啸轩内容管理系统V3', NULL, NULL, 1, NULL, '经工', '/uploads/img/202004/11/5e9196a178dc61139780.jpg', 1, '2020-04-14 11:25:48', 6, 1, NULL, 0),
	(38, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/25/5e54d326462560.jpg', 0, '2020-04-10 10:23:11', 1, 1, NULL, 0),
	(28, 3, '管理员管理', NULL, NULL, 0, 0, NULL, '', 0, '2020-04-07 12:46:45', 24, 1, NULL, 0),
	(29, 3, '管理员管理', NULL, NULL, 0, 0, NULL, '', 0, '2020-04-07 12:47:45', 1, 0, NULL, 0),
	(30, 3, '管理员管理', NULL, NULL, 0, 0, NULL, '', 0, '2020-04-07 12:49:14', 1, 0, NULL, 0),
	(31, 3, '管理员管理', NULL, NULL, 0, 0, NULL, '', 0, '2020-04-07 12:49:24', 2, 0, NULL, 0),
	(32, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '124', 0, '2020-04-07 12:50:33', 1, 1, NULL, 0),
	(33, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '124', 0, '2020-04-07 12:51:20', 1, 1, NULL, 0),
	(34, 8, '控制器中使用视图模板', 1, NULL, 0, 0, '经工', '', 0, '2020-04-12 11:28:42', 3, 1, NULL, 0),
	(35, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/25/5e54d326462560.jpg', 0, '2020-04-07 12:58:46', 13, 1, NULL, 0),
	(37, 6, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '', 0, '2020-04-09 11:52:18', 1, 1, NULL, 0),
	(40, 3, '管理员管理', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/25/5e54d326462560.jpg', 0, '2020-04-10 11:54:53', 2, 1, 1, 0),
	(41, 3, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, NULL, '2354', 0, '2020-04-10 17:03:34', 2, 1, 2, 0),
	(42, 3, '联播+丨统筹做好经济社会发展工作 习近平的战“疫”方略', NULL, NULL, 0, 0, NULL, '/public/uploads/img/202002/25/5e54d326462560.jpg', 0, '2020-04-10 17:07:30', 8, 1, 1, NULL),
	(43, 6, '管理员管理', NULL, NULL, 1, NULL, '经工', '/uploads/img/202004/11/5e919697a65772715070.jpg', 1, '2020-04-14 11:25:40', 2, 1, 1, 1),
	(44, 6, '联播+丨统筹做好经济社会发展工作 习近平的战“疫”方略', 1, 1, 1, NULL, '经工', '/uploads/img/202004/11/5e91c59a286a2853700.jpg', 1, '2020-04-14 11:23:43', 60, 1, 1, 1),
	(45, 6, '111123丨统筹做好经济社会发展工作 习近平的战“疫”方略', 1, NULL, 1, 1, '经工', '/uploads/img/202004/11/5e9196865d1f06978160.jpg', 1, '2020-04-14 11:23:26', 92, 1, 1, 1),
	(46, 3, '龙啸轩内容管理系统V3', NULL, NULL, 1, 0, '经工', '/uploads/img/202004/11/5e91994c62b396254680.jpg', 1, '2020-04-13 14:27:32', 18, 1, 1, 1),
	(47, 6, '龙啸轩内容管理系统V3测试长标题龙啸轩内容管理系统V3测试长标题龙啸轩内容管理系统V3测试长标题', 1, NULL, NULL, 1, '经工', '/uploads/img/202004/15/5e96c2aeae7281289310.jpg', 1, '2020-04-14 11:21:38', 148, 1, 1, 1),
	(48, 9, '龙啸轩内容管理系统V3', NULL, NULL, 0, 0, '经工', '', 0, '2020-04-12 12:39:18', 5, 1, 1, 1),
	(49, 3, '龙啸轩内容管理系统V3', 1, NULL, 1, 6, '经工', '/uploads/img/202005/03/5eae3e30d8ee64762380.jpg', 1, '2020-04-14 18:06:23', 54, 1, 1, 1),
	(50, 6, '龙啸轩内容管理系统V3', NULL, NULL, NULL, NULL, '经工', '/uploads/img/202004/14/5e9582738cd312533760.jpg', 1, '2020-04-15 16:10:31', 22, 1, 1, 1);
/*!40000 ALTER TABLE `cxuu_article` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_article_cate
CREATE TABLE IF NOT EXISTS `cxuu_article_cate` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(10) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `theme` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_article_cate: 9 rows
/*!40000 ALTER TABLE `cxuu_article_cate` DISABLE KEYS */;
INSERT INTO `cxuu_article_cate` (`id`, `pid`, `name`, `type`, `theme`) VALUES
	(1, 0, '新闻咨询', 0, ''),
	(2, 1, '国际新闻', 0, ''),
	(3, 2, '美国新闻', 1, ''),
	(4, 2, '菜单管理', 1, ''),
	(5, 0, '产品列表', 0, ''),
	(6, 5, '电子产品', 1, ''),
	(7, 2, '33管理', 0, ''),
	(8, 5, '生活用品', 1, 'list.html'),
	(9, 7, '文章内容', 1, '');
/*!40000 ALTER TABLE `cxuu_article_cate` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_article_content
CREATE TABLE IF NOT EXISTS `cxuu_article_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  PRIMARY KEY (`content_id`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_article_content: 23 rows
/*!40000 ALTER TABLE `cxuu_article_content` DISABLE KEYS */;
INSERT INTO `cxuu_article_content` (`content_id`, `aid`, `content`) VALUES
	(1, 39, '<p>123</p>'),
	(13, 40, '<p>管理员管理管理员管理管理员管理管理员管理管理员管理useriduseriduseriduseriduseriduseriduseriduseriduseriduserid</p>'),
	(14, 41, '<p>2352222</p>'),
	(15, 42, '<p>111111111111111111</p>'),
	(16, 43, '<p>123456</p>'),
	(17, 44, '<p>战略</p>'),
	(18, 45, '<div class="site-tips site-text" style="margin: 0px 0px 10px; padding: 15px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 22px; border-left: 5px solid #0078ad; background-color: #f2f2f2; position: relative; font-family: \'Helvetica Neue\', Helvetica, \'PingFang SC\', Tahoma, Arial, sans-serif; font-size: 14px;">\n<p style="margin: 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 22px;">layui 的所有图标全部采用字体形式，取材于阿里巴巴矢量图标库（iconfont）。因此你可以把一个 icon 看作是一个普通的文字，这意味着你直接用 css 控制文字属性，如 color、font-size，就可以改变图标的颜色和大小。你可以通过&nbsp;<em style="padding: 0px 3px; color: #666666;">font-class</em>&nbsp;或&nbsp;<em style="padding: 0px 3px; color: #666666;">unicode</em>&nbsp;来定义不同的图标。</p>\n</div>\n<div style="margin: 15px 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-family: \'Helvetica Neue\', Helvetica, \'PingFang SC\', Tahoma, Arial, sans-serif; font-size: 14px; text-align: center; background-color: #f2f2f2;"><ins class="adsbygoogle" style="display: inline-block; width: 728px; height: 90px;" data-ad-client="ca-pub-6111334333458862" data-ad-slot="9841027833" data-adsbygoogle-status="done"><ins id="aswift_0_expand" style="display: inline-table; border: none; height: 90px; margin: 0px; padding: 0px; position: relative; visibility: visible; width: 728px; background-color: transparent;"><ins id="aswift_0_anchor" style="display: block; border: none; height: 90px; margin: 0px; padding: 0px; position: relative; visibility: visible; width: 728px; background-color: transparent;"><iframe id="aswift_0" style="left: 0px; position: absolute; top: 0px; border-width: 0px; border-style: initial; width: 728px; height: 90px;" name="aswift_0" width="728" height="90" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" allowfullscreen="allowfullscreen"></iframe></ins></ins></ins></div>\n<div class="site-title" style="margin: 30px 0px 20px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-family: \'Helvetica Neue\', Helvetica, \'PingFang SC\', Tahoma, Arial, sans-serif; font-size: 14px;"><fieldset style="border-right: none; border-bottom: none; border-left: none; padding: 0px; border-top: 1px solid #eeeeee;"><legend style="margin-left: 20px; padding: 0px 10px; font-size: 22px;"><a style="color: #333333;" name="use"></a>使用方式</legend></fieldset></div>\n<div class="site-text" style="margin: 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); position: relative; font-family: \'Helvetica Neue\', Helvetica, \'PingFang SC\', Tahoma, Arial, sans-serif; font-size: 14px;">\n<p style="margin: 0px 0px 10px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); line-height: 22px;">通过对一个内联元素（一般推荐用&nbsp;<em style="padding: 0px 3px; color: #666666;">i</em>标签）设定&nbsp;<em style="padding: 0px 3px; color: #666666;">class="layui-icon"</em>，来定义一个图标，然后对元素加上图标对应的&nbsp;<em style="padding: 0px 3px; color: #666666;">font-class</em>（注意：layui 2.3.0 之前只支持采用&nbsp;<em style="padding: 0px 3px; color: #666666;">unicode 字符</em>)，即可显示出你想要的图标，譬如：</p>\n<h3 class="layui-code-h3" style="font-weight: 400; margin: 0px; padding: 0px 10px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-size: 12px; box-sizing: content-box; position: relative; height: 32px; line-height: 32px; border-bottom: 1px solid #e2e2e2;">code<a style="color: #999999; text-decoration-line: none; box-sizing: content-box; position: absolute; right: 10px; top: 0px;" href="http://www.layui.com/doc/modules/code.html" target="_blank" rel="noopener">layui.code</a></h3>\n<ol class="layui-code-ol" style="margin: 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); box-sizing: content-box; position: relative; overflow: auto;">\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">从 layui 2.3.0 开始，支持 font-class 的形式定义图标：</li>\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">&nbsp;</li>\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">\n<h3 class="layui-code-h3" style="font-weight: 400; margin: 0px; padding: 0px 10px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-size: 12px; box-sizing: content-box; position: relative; height: 32px; line-height: 32px; border-bottom: 1px solid #e2e2e2;">code<a style="color: #999999; text-decoration-line: none; box-sizing: content-box; position: absolute; right: 10px; top: 0px;" href="http://www.layui.com/doc/modules/code.html" target="_blank" rel="noopener">layui.code</a></h3>\n<ol class="layui-code-ol" style="margin: 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); box-sizing: content-box; position: relative; overflow: auto;">\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">注意：在 layui 2.3.0 之前的版本，只能设置 unicode 来定义图标</li>\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;"><em class="layui-icon"></em></li>\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">其中的  即是图标对应的 unicode 字符</li>\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">&nbsp;</li>\n</ol>\n</li>\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">&nbsp;</li>\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">你可以去定义它的颜色或者大小，如：</li>\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">&nbsp;</li>\n<li style="margin: 0px 0px 0px 45px; padding: 0px 5px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); list-style: decimal-leading-zero; box-sizing: content-box; position: relative; line-height: 20px; border-left: 1px solid #e2e2e2; background-color: #ffffff;">&nbsp;</li>\n</ol>\n</div>'),
	(19, 46, '<p>datedatedatedatedatedatedate</p>'),
	(20, 47, '<h1 id="h1-u63A7u5236u5668u4E2Du4F7Fu7528u89C6u56FEu6A21u677F" style="box-sizing: border-box; margin: 1em 0px 16px; padding-bottom: 0.3em; border-bottom: 1px solid #eeeeee; position: relative; line-height: 1.2; font-size: 2.25em; color: #333333; font-family: \'Microsoft YaHei\', Helvetica, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Monaco, monospace, Tahoma, STXihei, 华文细黑, STHeiti, \'Helvetica Neue\', \'Droid Sans\', \'wenquanyi micro hei\', FreeSans, Arimo, Arial, SimSun, 宋体, Heiti, 黑体, sans-serif;">&nbsp;</h1>\n<ol class="linenums" style="box-sizing: border-box; padding: 0px 0px 0px 5px; margin-top: 0px; margin-bottom: 0px; color: #999999;">\n<li class="L0" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pun" style="box-sizing: border-box; color: #666600;">&lt;?</span><span class="pln" style="box-sizing: border-box; color: #000000;">php</span></code></li>\n<li class="L1" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="kwd" style="box-sizing: border-box; color: #000088;">namespace</span><span class="pln" style="box-sizing: border-box; color: #000000;"> ctrl</span><span class="pun" style="box-sizing: border-box; color: #666600;">;</span></code></li>\n<li class="L2" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="kwd" style="box-sizing: border-box; color: #000088;">use</span><span class="pln" style="box-sizing: border-box; color: #000000;"> z\\view</span><span class="pun" style="box-sizing: border-box; color: #666600;">;</span><span class="pln" style="box-sizing: border-box; color: #000000;">            </span><span class="com" style="box-sizing: border-box; color: #880000;">// 使用view视图类</span></code></li>\n<li class="L3" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="kwd" style="box-sizing: border-box; color: #000088;">class</span><span class="pln" style="box-sizing: border-box; color: #000000;"> index </span><span class="pun" style="box-sizing: border-box; color: #666600;">{</span></code></li>\n<li class="L4" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">    </span><span class="kwd" style="box-sizing: border-box; color: #000088;">function</span><span class="pln" style="box-sizing: border-box; color: #000000;"> index </span><span class="pun" style="box-sizing: border-box; color: #666600;">()</span></code></li>\n<li class="L5" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">    </span><span class="pun" style="box-sizing: border-box; color: #666600;">{</span></code></li>\n<li class="L6" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        $user </span><span class="pun" style="box-sizing: border-box; color: #666600;">=</span><span class="pln" style="box-sizing: border-box; color: #000000;"> </span><span class="pun" style="box-sizing: border-box; color: #666600;">[</span></code></li>\n<li class="L7" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">            </span><span class="str" style="box-sizing: border-box; color: #008800;">\'username\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">=&gt;</span><span class="str" style="box-sizing: border-box; color: #008800;">\'user\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">,</span></code></li>\n<li class="L8" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">            </span><span class="str" style="box-sizing: border-box; color: #008800;">\'userid\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">=&gt;</span><span class="lit" style="box-sizing: border-box; color: #006666;">123</span><span class="pun" style="box-sizing: border-box; color: #666600;">,</span></code></li>\n<li class="L9" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        </span><span class="pun" style="box-sizing: border-box; color: #666600;">];</span></code></li>\n<li class="L0" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        $data </span><span class="pun" style="box-sizing: border-box; color: #666600;">=</span><span class="pln" style="box-sizing: border-box; color: #000000;"> </span><span class="pun" style="box-sizing: border-box; color: #666600;">[</span></code></li>\n<li class="L1" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">            </span><span class="str" style="box-sizing: border-box; color: #008800;">\'head\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">=&gt;</span><span class="str" style="box-sizing: border-box; color: #008800;">\'this is head\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">,</span></code></li>\n<li class="L2" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">            </span><span class="str" style="box-sizing: border-box; color: #008800;">\'body\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">=&gt;</span><span class="str" style="box-sizing: border-box; color: #008800;">\'this is body\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">,</span></code></li>\n<li class="L3" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        </span><span class="pun" style="box-sizing: border-box; color: #666600;">];</span></code></li>\n<li class="L4" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        $login </span><span class="pun" style="box-sizing: border-box; color: #666600;">=</span><span class="pln" style="box-sizing: border-box; color: #000000;"> </span><span class="kwd" style="box-sizing: border-box; color: #000088;">false</span><span class="pun" style="box-sizing: border-box; color: #666600;">;</span></code></li>\n<li class="L5" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"></code></li>\n<li class="L6" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        view</span><span class="pun" style="box-sizing: border-box; color: #666600;">::</span><span class="typ" style="box-sizing: border-box; color: #660066;">Assign</span><span class="pun" style="box-sizing: border-box; color: #666600;">(</span><span class="str" style="box-sizing: border-box; color: #008800;">\'user\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">,</span><span class="pln" style="box-sizing: border-box; color: #000000;"> $user</span><span class="pun" style="box-sizing: border-box; color: #666600;">);</span><span class="pln" style="box-sizing: border-box; color: #000000;">      </span><span class="com" style="box-sizing: border-box; color: #880000;">// 分配user变量</span></code></li>\n<li class="L7" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        view</span><span class="pun" style="box-sizing: border-box; color: #666600;">::</span><span class="typ" style="box-sizing: border-box; color: #660066;">Assign</span><span class="pun" style="box-sizing: border-box; color: #666600;">(</span><span class="str" style="box-sizing: border-box; color: #008800;">\'data\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">,</span><span class="pln" style="box-sizing: border-box; color: #000000;"> $data</span><span class="pun" style="box-sizing: border-box; color: #666600;">);</span><span class="pln" style="box-sizing: border-box; color: #000000;">      </span><span class="com" style="box-sizing: border-box; color: #880000;">// 分配data变量</span></code></li>\n<li class="L8" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        view</span><span class="pun" style="box-sizing: border-box; color: #666600;">::</span><span class="typ" style="box-sizing: border-box; color: #660066;">Assign</span><span class="pun" style="box-sizing: border-box; color: #666600;">(</span><span class="str" style="box-sizing: border-box; color: #008800;">\'login\'</span><span class="pun" style="box-sizing: border-box; color: #666600;">,</span><span class="pln" style="box-sizing: border-box; color: #000000;"> $login</span><span class="pun" style="box-sizing: border-box; color: #666600;">);</span><span class="pln" style="box-sizing: border-box; color: #000000;">    </span><span class="com" style="box-sizing: border-box; color: #880000;">// 分配login变量</span></code></li>\n<li class="L9" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"></code></li>\n<li class="L0" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        view</span><span class="pun" style="box-sizing: border-box; color: #666600;">::</span><span class="typ" style="box-sizing: border-box; color: #660066;">Display</span><span class="pun" style="box-sizing: border-box; color: #666600;">();</span><span class="pln" style="box-sizing: border-box; color: #000000;">    </span><span class="com" style="box-sizing: border-box; color: #880000;">// 渲染默认路径下的模板</span></code></li>\n<li class="L1" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">        </span><span class="com" style="box-sizing: border-box; color: #880000;">// view::Display(\'default/user/index\'); // 渲染default样式目录下/user/index.html的模板</span></code></li>\n<li class="L2" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">    </span><span class="pun" style="box-sizing: border-box; color: #666600;">}</span></code></li>\n<li class="L3" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pun" style="box-sizing: border-box; color: #666600;">}</span></code></li>\n</ol>\n<h1 id="h1-u6A21u677Fu8DEFu5F84" style="box-sizing: border-box; margin: 1em 0px 16px; padding-bottom: 0.3em; border-bottom: 1px solid #eeeeee; position: relative; line-height: 1.2; font-size: 2.25em; color: #333333; font-family: \'Microsoft YaHei\', Helvetica, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Monaco, monospace, Tahoma, STXihei, 华文细黑, STHeiti, \'Helvetica Neue\', \'Droid Sans\', \'wenquanyi micro hei\', FreeSans, Arimo, Arial, SimSun, 宋体, Heiti, 黑体, sans-serif;"><a class="reference-link" style="color: #4183c4; box-sizing: border-box; background-image: initial; background-position: 0px 0px; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;" name="模板路径"></a>模板路径</h1>\n<p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; color: #333333; font-family: \'Microsoft YaHei\', Helvetica, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Monaco, monospace, Tahoma, STXihei, 华文细黑, STHeiti, \'Helvetica Neue\', \'Droid Sans\', \'wenquanyi micro hei\', FreeSans, Arimo, Arial, SimSun, 宋体, Heiti, 黑体, sans-serif; font-size: 14px;"><span style="box-sizing: border-box; font-weight: bold;">默认路径：当前风格目录/控制器名/操作名.html</span></p>\n<p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; color: #333333; font-family: \'Microsoft YaHei\', Helvetica, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Monaco, monospace, Tahoma, STXihei, 华文细黑, STHeiti, \'Helvetica Neue\', \'Droid Sans\', \'wenquanyi micro hei\', FreeSans, Arimo, Arial, SimSun, 宋体, Heiti, 黑体, sans-serif; font-size: 14px;"><span style="box-sizing: border-box; font-weight: bold;">view::Display(&lsquo;index&rsquo;) 路径：当前风格目录/控制器名/index.html</span></p>\n<p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; color: #333333; font-family: \'Microsoft YaHei\', Helvetica, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Monaco, monospace, Tahoma, STXihei, 华文细黑, STHeiti, \'Helvetica Neue\', \'Droid Sans\', \'wenquanyi micro hei\', FreeSans, Arimo, Arial, SimSun, 宋体, Heiti, 黑体, sans-serif; font-size: 14px;"><span style="box-sizing: border-box; font-weight: bold;">view::Display(&lsquo;user/index&rsquo;) 路径：当前风格目录/user/index.html</span></p>\n<p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; color: #333333; font-family: \'Microsoft YaHei\', Helvetica, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Monaco, monospace, Tahoma, STXihei, 华文细黑, STHeiti, \'Helvetica Neue\', \'Droid Sans\', \'wenquanyi micro hei\', FreeSans, Arimo, Arial, SimSun, 宋体, Heiti, 黑体, sans-serif; font-size: 14px;"><span style="box-sizing: border-box; font-weight: bold;">view::Display(&lsquo;user/<span style="box-sizing: border-box; color: red;">new_dir</span>/header&rsquo;) 路径：当前风格目录/user/<span style="box-sizing: border-box; color: red;">new_dir</span>/header.html</span></p>\n<p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; color: #333333; font-family: \'Microsoft YaHei\', Helvetica, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Monaco, monospace, Tahoma, STXihei, 华文细黑, STHeiti, \'Helvetica Neue\', \'Droid Sans\', \'wenquanyi micro hei\', FreeSans, Arimo, Arial, SimSun, 宋体, Heiti, 黑体, sans-serif; font-size: 14px;"><span style="box-sizing: border-box; font-weight: bold;">其它风格目录下的文件请使用绝对路径，可以配合常量使用</span></p>\n<ol class="linenums" style="box-sizing: border-box; padding: 0px 0px 0px 5px; margin-top: 0px; margin-bottom: 0px; color: #999999;">\n<li class="L0" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">$tpl </span><span class="pun" style="box-sizing: border-box; color: #666600;">=</span><span class="pln" style="box-sizing: border-box; color: #000000;"> P_VIEW_MODULE </span><span class="pun" style="box-sizing: border-box; color: #666600;">.</span><span class="pln" style="box-sizing: border-box; color: #000000;"> </span><span class="str" style="box-sizing: border-box; color: #008800;">\'theme/user/index.html\'</span></code></li>\n<li class="L1" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="com" style="box-sizing: border-box; color: #880000;">// 当前模块模板目录/theme风格目录/user/index.html</span></code></li>\n<li class="L2" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">view</span><span class="pun" style="box-sizing: border-box; color: #666600;">::</span><span class="typ" style="box-sizing: border-box; color: #660066;">Display</span><span class="pun" style="box-sizing: border-box; color: #666600;">(</span><span class="pln" style="box-sizing: border-box; color: #000000;">$tpl</span><span class="pun" style="box-sizing: border-box; color: #666600;">)</span></code></li>\n</ol>\n<p style="box-sizing: border-box; margin-top: 0px; margin-bottom: 16px; color: #333333; font-family: \'Microsoft YaHei\', Helvetica, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Monaco, monospace, Tahoma, STXihei, 华文细黑, STHeiti, \'Helvetica Neue\', \'Droid Sans\', \'wenquanyi micro hei\', FreeSans, Arimo, Arial, SimSun, 宋体, Heiti, 黑体, sans-serif; font-size: 14px;"><span style="box-sizing: border-box; font-weight: bold;">其它模块目录</span></p>\n<ol class="linenums" style="box-sizing: border-box; padding: 0px 0px 0px 5px; margin-top: 0px; margin-bottom: 0px; color: #999999;">\n<li class="L0" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">$tpl </span><span class="pun" style="box-sizing: border-box; color: #666600;">=</span><span class="pln" style="box-sizing: border-box; color: #000000;"> P_APP_VER </span><span class="pun" style="box-sizing: border-box; color: #666600;">.</span><span class="pln" style="box-sizing: border-box; color: #000000;"> </span><span class="str" style="box-sizing: border-box; color: #008800;">\'test/view/\'</span><span class="pln" style="box-sizing: border-box; color: #000000;"> </span><span class="pun" style="box-sizing: border-box; color: #666600;">.</span><span class="pln" style="box-sizing: border-box; color: #000000;"> THEME </span><span class="pun" style="box-sizing: border-box; color: #666600;">.</span><span class="pln" style="box-sizing: border-box; color: #000000;"> </span><span class="str" style="box-sizing: border-box; color: #008800;">\'/user/index.html\'</span></code></li>\n<li class="L1" style="list-style-type: none; box-sizing: border-box; background-image: initial; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="com" style="box-sizing: border-box; color: #880000;">// 当前应用目录/test模块/模板目录/当前风格目录/user/index.html</span></code></li>\n<li class="L2" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"><span class="pln" style="box-sizing: border-box; color: #000000;">view</span><span class="pun" style="box-sizing: border-box; color: #666600;">::</span><span class="typ" style="box-sizing: border-box; color: #660066;">Display</span><span class="pun" style="box-sizing: border-box; color: #666600;">(</span><span class="pln" style="box-sizing: border-box; color: #000000;">$tpl</span><span class="pun" style="box-sizing: border-box; color: #666600;">)</span></code></li>\n<li class="L2" style="list-style-type: none; box-sizing: border-box;"><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"></code></li>\n<li class="L2" style="list-style-type: none; box-sizing: border-box;"><img src="/uploads/img/202004/15/5e96c2aeae7281289310.jpg" alt="" width="525" height="300" /><code style="box-sizing: border-box; font-family: \'YaHei Consolas Hybrid\', Consolas, \'Meiryo UI\', \'Malgun Gothic\', \'Segoe UI\', \'Trebuchet MS\', Helvetica, monospace, monospace; padding: 0px; margin: 0px; font-size: 14px; background: 0px 0px; border: none; display: inline; max-width: initial; overflow: initial; line-height: inherit; overflow-wrap: normal; color: #dd1144;"></code></li>\n</ol>'),
	(21, 48, '<p>88888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888</p>'),
	(22, 49, '<p><img src="/uploads/img/202005/03/5eae3e30d8ee64762380.jpg" alt="" width="1280" height="853" />214214<img src="/uploads/img/202004/14/5e958b179cdb68093990.jpg" alt="" width="533" height="300" /></p>'),
	(23, 50, '<p><img src="/uploads/img/202004/14/5e9583208a5fa3291290.jpg" alt="" width="890" height="890" /></p>\n<p>2</p>\n<table style="border-collapse: collapse; width: 100%;" border="1">\n<tbody>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n<tr>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n<td style="width: 10%;">&nbsp;</td>\n</tr>\n</tbody>\n</table>');
/*!40000 ALTER TABLE `cxuu_article_content` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_attments
CREATE TABLE IF NOT EXISTS `cxuu_attments` (
  `attid` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) DEFAULT NULL COMMENT '文章ID',
  `atturl` varchar(150) DEFAULT NULL COMMENT '附件地址',
  `priname` varchar(50) DEFAULT NULL COMMENT '原始名',
  `ext` varchar(5) DEFAULT NULL COMMENT '文件类型',
  `size` int(10) DEFAULT NULL COMMENT '文件大小',
  PRIMARY KEY (`attid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_attments: 6 rows
/*!40000 ALTER TABLE `cxuu_attments` DISABLE KEYS */;
INSERT INTO `cxuu_attments` (`attid`, `aid`, `atturl`, `priname`, `ext`, `size`) VALUES
	(1, NULL, NULL, NULL, NULL, NULL),
	(2, NULL, NULL, NULL, NULL, NULL),
	(3, NULL, '/uploads/attment/202004/13/5e941d1f987535638860.txt', '1.txt', NULL, 98),
	(4, NULL, '/uploads/attment/202004/13/5e9420337090f2767570.txt', '1.txt', '.txt', 98),
	(5, NULL, '/uploads/attment/202004/13/5e94212180aad5171860.txt', '1.txt', '.txt', 98),
	(6, NULL, '/uploads/attment/202004/14/5e951055c6aef8122400.txt', '新建文本文档.txt', '.txt', 1223),
	(7, NULL, '/uploads/attment/202005/05/5eb12b575665b908980.txt', '新建文本文档.txt', '.txt', 74),
	(8, NULL, NULL, NULL, NULL, NULL),
	(9, NULL, '/uploads/attment/202005/05/5eb12c63912ee2602930.txt', '新建文本文档.txt', '.txt', 74),
	(10, NULL, '/uploads/attment/202005/05/5eb131a980c662707580.txt', '新建文本文档.txt', '.txt', 74),
	(11, NULL, NULL, NULL, NULL, NULL),
	(12, NULL, '/uploads/attment/202005/05/5eb1341e1cf593114040.txt', '新建文本文档.txt', '.txt', 74);
/*!40000 ALTER TABLE `cxuu_attments` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_images
CREATE TABLE IF NOT EXISTS `cxuu_images` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `img` varchar(150) DEFAULT NULL COMMENT '缩略图',
  `auther` varchar(50) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_images: ~2 rows (大约)
/*!40000 ALTER TABLE `cxuu_images` DISABLE KEYS */;
INSERT INTO `cxuu_images` (`id`, `title`, `img`, `auther`, `content`, `status`, `time`) VALUES
	(1, '拉萨扫黑除恶宣传片二', '/uploads/img/202004/28/5ea795a7947417044290.jpg', '汪汪', '拉萨扫黑除恶宣传片二', 1, '2020-04-28 10:24:39'),
	(2, '第101期 我局召开全市专题工作会议', '/uploads/img/202004/28/5ea7b6027d6d49573050.png', '汪汪', '2143214', 1, '2020-04-28 12:50:19');
/*!40000 ALTER TABLE `cxuu_images` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_images_image
CREATE TABLE IF NOT EXISTS `cxuu_images_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aid` int(11) DEFAULT NULL,
  `imgsrc` varchar(150) DEFAULT NULL,
  `info` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_images_image: ~5 rows (大约)
/*!40000 ALTER TABLE `cxuu_images_image` DISABLE KEYS */;
INSERT INTO `cxuu_images_image` (`id`, `aid`, `imgsrc`, `info`) VALUES
	(1, 1, '/uploads/img/202004/28/5ea7aab7da1c83470850.jpg\r\n', '415'),
	(2, 1, '/uploads/img/202004/28/5ea7b5be702651589320.jpg', '2'),
	(3, 1, '/uploads/img/202004/28/5ea7b5c4a457f7483780.jpg', '142'),
	(4, 1, '/uploads/img/202004/28/5ea7b5f15409c2673640.jpg', '4235'),
	(5, 2, '/uploads/img/202004/28/5ea7b611da9f69126270.jpg', '1234242');
/*!40000 ALTER TABLE `cxuu_images_image` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_member
CREATE TABLE IF NOT EXISTS `cxuu_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `duties` varchar(50) DEFAULT NULL,
  `photo` varchar(150) DEFAULT NULL,
  `duty` varchar(150) DEFAULT NULL,
  `sort` int(3) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_member: ~2 rows (大约)
/*!40000 ALTER TABLE `cxuu_member` DISABLE KEYS */;
INSERT INTO `cxuu_member` (`id`, `name`, `duties`, `photo`, `duty`, `sort`, `status`) VALUES
	(1, '周凯', '国家主席', '/uploads/img/202005/03/5eae3e3c9cfd57781200.jpg', '主持全国工作，主持全国工作，主持全国工作，主持中央工作', 1, 1),
	(2, '常迎霞', '国务院总理、财政部长', '/uploads/img/202005/03/5eae3e550293d4472670.jpg', '全国政府工作、全国财政工作', 2, 1);
/*!40000 ALTER TABLE `cxuu_member` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_notices
CREATE TABLE IF NOT EXISTS `cxuu_notices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `content` mediumtext DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_notices: 18 rows
/*!40000 ALTER TABLE `cxuu_notices` DISABLE KEYS */;
INSERT INTO `cxuu_notices` (`id`, `title`, `img`, `content`, `time`, `status`) VALUES
	(2, '龙啸轩内容管理系统V3', NULL, '22', '2020-02-14 16:29:00', 0),
	(3, '龙啸轩内容管理系统V3', NULL, 'asf', '2020-02-14 13:53:47', 1),
	(4, 'cxuuweb 3.0来了', NULL, '这个系统是全新构建的，效率高，扩展性强！', '2020-02-14 13:55:13', 1),
	(5, '龙啸轩内容管理系统V3', NULL, '2222222222222222222', '2020-02-14 14:05:42', 1),
	(6, '龙啸轩内容管理系统V3', NULL, '在要', '2020-02-14 14:08:25', 1),
	(8, '龙啸轩内容管理系统V3', NULL, '21424', '2020-02-14 19:04:39', 1),
	(9, '龙啸轩内容管理系统V3', NULL, '124312', '2020-02-14 16:01:01', 1),
	(10, '龙啸轩内容管理系统V3', NULL, '214', '2020-02-14 14:08:53', 1),
	(11, '龙啸轩内容管理系统V3', NULL, '124', '2020-02-14 14:08:57', 0),
	(12, '龙啸轩内容管理系统V3', NULL, '3245', '2020-02-14 14:09:02', 0),
	(13, '龙啸轩内容管理系统V3', NULL, 'qwrq', '2020-02-14 15:03:16', 1),
	(14, '龙啸轩内容管理系统V3', NULL, 'asfd', '2020-02-16 14:55:41', 1),
	(15, '龙啸轩内容管理系统V3', '', '腑', '2020-04-08 10:27:22', 1),
	(17, '龙啸轩内容管理系统V3', NULL, '235', '2020-02-16 16:16:58', 0),
	(19, '龙啸轩内容管理系统V3', '/public/uploads/img/202002/21/5e4f5ec883bf90.jpg', '12314', '2020-02-29 17:24:01', 1),
	(20, '龙啸轩内容管理系统V3', '/public/uploads/img/202002/29/5e5a2986d65b70.jpg', '', '2020-02-29 17:23:56', 0),
	(21, '龙啸轩内容管理系统V3', '/uploads/img/202004/07/5e8c3cbe3edb07010840.jpg', 'ss', '2020-04-12 10:24:42', 0),
	(22, '龙啸轩内容管理系统V3', '/public/uploads/img/202002/25/5e54d326462560.jpg', '1111', '2020-04-07 17:08:51', 1);
/*!40000 ALTER TABLE `cxuu_notices` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_onduty
CREATE TABLE IF NOT EXISTS `cxuu_onduty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `juname` varchar(50) DEFAULT NULL COMMENT '局值班人',
  `chuname` varchar(50) DEFAULT NULL COMMENT '处值班人',
  `yuanname` varchar(50) DEFAULT NULL COMMENT '值班员',
  `phone` varchar(12) DEFAULT NULL COMMENT '职务',
  `ondutytime` date DEFAULT NULL COMMENT '值班时间',
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_onduty: 2 rows
/*!40000 ALTER TABLE `cxuu_onduty` DISABLE KEYS */;
INSERT INTO `cxuu_onduty` (`id`, `juname`, `chuname`, `yuanname`, `phone`, `ondutytime`, `status`) VALUES
	(1, '张某', '李某', '周某', '6888888', '2020-04-25', 1),
	(2, '张某1', '李某', '周某', '13889009375', '2020-04-26', 1);
/*!40000 ALTER TABLE `cxuu_onduty` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_siteconfig
CREATE TABLE IF NOT EXISTS `cxuu_siteconfig` (
  `name` varchar(50) NOT NULL,
  `data` text DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_siteconfig: 2 rows
/*!40000 ALTER TABLE `cxuu_siteconfig` DISABLE KEYS */;
INSERT INTO `cxuu_siteconfig` (`name`, `data`) VALUES
	('siteinfo', 'a:5:{s:8:"sitename";s:16:"龙啸轩网络1";s:7:"siteurl";s:20:"http://www.cxuu.net/";s:8:"keywords";s:19:"龙啸轩网络2233";s:8:"descript";s:15:"龙啸轩网络";s:9:"copyright";s:88:"龙啸轩内容管理系统 便捷易用的网站内容管理平台  浏览器支持IE8+";}'),
	('upload', 'a:3:{s:10:"uploadsize";s:4:"2048";s:12:"imguploadext";s:20:".jpg|.png|.jpeg|.gif";s:12:"attuploadext";s:40:".doc|.docx|.zip|.7z|.zip|.xls|.xlsx|.txt";}'),
	('cache', 'a:6:{s:9:"indexhtml";s:1:"1";s:13:"indexhtmltime";s:4:"1133";s:11:"visitscache";s:1:"1";s:9:"visitsnum";s:2:"51";s:10:"visitstime";s:3:"500";s:14:"visitsshowtime";s:3:"600";}');
/*!40000 ALTER TABLE `cxuu_siteconfig` ENABLE KEYS */;

-- Dumping structure for table cxuuweb.cxuu_visits
CREATE TABLE IF NOT EXISTS `cxuu_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `visits` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- Dumping data for table cxuuweb.cxuu_visits: 10 rows
/*!40000 ALTER TABLE `cxuu_visits` DISABLE KEYS */;
INSERT INTO `cxuu_visits` (`id`, `date`, `visits`) VALUES
	(39, '2020-04-29', 111),
	(38, '2020-04-28', 101),
	(37, '2020-04-26', 61),
	(36, '2020-04-25', 31),
	(35, '2020-04-24', 31),
	(34, '2020-04-22', 21333),
	(33, '2020-04-23', 326),
	(40, '2020-05-02', 1),
	(41, '2020-05-03', 31),
	(42, '2020-05-04', 22),
	(43, '2020-05-05', 156);
/*!40000 ALTER TABLE `cxuu_visits` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
