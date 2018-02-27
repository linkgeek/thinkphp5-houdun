/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50715
Source Host           : localhost:3306
Source Database       : tp5

Target Server Type    : MYSQL
Target Server Version : 50715
File Encoding         : 65001

Date: 2018-01-15 23:53:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for blog_admin
-- ----------------------------
DROP TABLE IF EXISTS `blog_admin`;
CREATE TABLE `blog_admin` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `uflag` int(11) NOT NULL,
  `identifier` varchar(32) NOT NULL,
  `token` varchar(32) NOT NULL,
  `timeout` int(11) NOT NULL,
  `email` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_admin
-- ----------------------------
INSERT INTO `blog_admin` VALUES ('1', 'admin', 'b/n9zZau+91GNezNhXZv0Q==', '0', '', '', '0', '941192051@qq.com');

-- ----------------------------
-- Table structure for blog_arc_tag
-- ----------------------------
DROP TABLE IF EXISTS `blog_arc_tag`;
CREATE TABLE `blog_arc_tag` (
  `arc_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  KEY `fk_table1_blog_article1_idx` (`arc_id`),
  KEY `fk_table1_blog_tag1_idx` (`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章标签中间表';

-- ----------------------------
-- Records of blog_arc_tag
-- ----------------------------
INSERT INTO `blog_arc_tag` VALUES ('1', '3');
INSERT INTO `blog_arc_tag` VALUES ('1', '2');
INSERT INTO `blog_arc_tag` VALUES ('4', '9');
INSERT INTO `blog_arc_tag` VALUES ('4', '5');

-- ----------------------------
-- Table structure for blog_article
-- ----------------------------
DROP TABLE IF EXISTS `blog_article`;
CREATE TABLE `blog_article` (
  `arc_id` int(11) NOT NULL AUTO_INCREMENT,
  `arc_title` varchar(45) NOT NULL DEFAULT '' COMMENT '文章标题',
  `arc_author` varchar(45) NOT NULL DEFAULT '' COMMENT '文章作者',
  `arc_digest` varchar(200) NOT NULL DEFAULT '' COMMENT '文章摘要',
  `arc_content` text,
  `sendtime` int(11) NOT NULL DEFAULT '0' COMMENT '发表时间',
  `updatetime` int(11) NOT NULL DEFAULT '0' COMMENT '文章更新时间',
  `arc_click` int(11) NOT NULL DEFAULT '0' COMMENT '点击次数',
  `is_recycle` tinyint(4) NOT NULL DEFAULT '2' COMMENT '是否在回收站，1在回收站2代表不在回收站，默认2',
  `arc_thumb` varchar(100) NOT NULL DEFAULT '' COMMENT '文章缩略图',
  `cate_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `arc_sort` int(11) NOT NULL DEFAULT '100' COMMENT '文章排序',
  PRIMARY KEY (`arc_id`),
  KEY `fk_blog_article_blog_cate_idx` (`cate_id`),
  KEY `fk_blog_article_blog_admin1_idx` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of blog_article
-- ----------------------------
INSERT INTO `blog_article` VALUES ('1', '东方红吧答复客户具 ', '地方', '三个人VBas', '<p>地方GV备份</p><p><img src=\"http://localhost/thinkphp5/public/uploads/20180107/152ed9c1ed2110e5f464af7524bd88d4.jpg\"/></p>', '1515325139', '1516031545', '4', '2', 'http://localhost/thinkphp5/public/uploads/20180107/65e2ebce89b5dd0cb6ed7693b992ba02.jpg', '1', '1', '201');
INSERT INTO `blog_article` VALUES ('4', '这是一篇新的文章测试啦啦啦', '加藤非', '的国防部我的发不发达', '<p>VB发送到发布第三方不是对方大事发生地方</p><p><img src=\"http://localhost/thinkphp5/public/uploads/20180107/65e2ebce89b5dd0cb6ed7693b992ba02.jpg\"/></p>', '1515945642', '1516031452', '4', '2', 'http://localhost/thinkphp5/public/uploads/20180107/152ed9c1ed2110e5f464af7524bd88d4.jpg', '1', '1', '100');

-- ----------------------------
-- Table structure for blog_attachment
-- ----------------------------
DROP TABLE IF EXISTS `blog_attachment`;
CREATE TABLE `blog_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `filename` varchar(300) NOT NULL COMMENT '文件名',
  `path` varchar(300) NOT NULL COMMENT '路径',
  `extension` varchar(10) NOT NULL DEFAULT '' COMMENT '类型',
  `createtime` int(10) NOT NULL COMMENT '上传时间',
  `size` mediumint(9) NOT NULL COMMENT '文件大小',
  PRIMARY KEY (`id`),
  KEY `extension` (`extension`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='附件';

-- ----------------------------
-- Records of blog_attachment
-- ----------------------------
INSERT INTO `blog_attachment` VALUES ('1', '8be4-fyiiahz3752269.jpg', '152ed9c1ed2110e5f464af7524bd88d4.jpg', 'uploads/20180107/152ed9c1ed2110e5f464af7524bd88d4.jpg', 'jpg', '1515313352', '575464');
INSERT INTO `blog_attachment` VALUES ('2', '48.jpg', 'db2671b03dee6341bba3d2f99a16a227.jpg', 'uploads/20180107/db2671b03dee6341bba3d2f99a16a227.jpg', 'jpg', '1515313371', '109943');
INSERT INTO `blog_attachment` VALUES ('3', '1474614434842641.jpg', '3408e50bc8ee1ca0b52c86888c8e076e.jpg', 'uploads/20180107/3408e50bc8ee1ca0b52c86888c8e076e.jpg', 'jpg', '1515313392', '34742');
INSERT INTO `blog_attachment` VALUES ('4', '2015100132790603.jpg', '65e2ebce89b5dd0cb6ed7693b992ba02.jpg', 'uploads/20180107/65e2ebce89b5dd0cb6ed7693b992ba02.jpg', 'jpg', '1515313480', '659295');
INSERT INTO `blog_attachment` VALUES ('5', '1ZQ64396-5.jpg', 'c291cedd8780907f65321464cca9f80f.jpg', 'uploads/20180107/c291cedd8780907f65321464cca9f80f.jpg', 'jpg', '1515313833', '57487');

-- ----------------------------
-- Table structure for blog_category
-- ----------------------------
DROP TABLE IF EXISTS `blog_category`;
CREATE TABLE `blog_category` (
  `cate_id` int(11) NOT NULL AUTO_INCREMENT,
  `cate_name` varchar(32) DEFAULT NULL,
  `cate_pid` int(11) DEFAULT '0',
  `cate_sort` int(11) DEFAULT '100',
  PRIMARY KEY (`cate_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_category
-- ----------------------------
INSERT INTO `blog_category` VALUES ('1', '视频学习', '0', '1');
INSERT INTO `blog_category` VALUES ('2', '开源产品', '0', '2');
INSERT INTO `blog_category` VALUES ('3', 'hdphp', '2', '3');
INSERT INTO `blog_category` VALUES ('4', 'hdcms', '2', '4');
INSERT INTO `blog_category` VALUES ('6', '学习笔记', '0', '5');

-- ----------------------------
-- Table structure for blog_link
-- ----------------------------
DROP TABLE IF EXISTS `blog_link`;
CREATE TABLE `blog_link` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(45) NOT NULL DEFAULT '' COMMENT '友链名称',
  `link_url` varchar(100) NOT NULL DEFAULT '' COMMENT '友链url',
  `link_sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '友链排序',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='友链数据表';

-- ----------------------------
-- Records of blog_link
-- ----------------------------
INSERT INTO `blog_link` VALUES ('1', '百度一下', 'https://www.baidu.com', '1');
INSERT INTO `blog_link` VALUES ('2', '创融', 'http://www.tronron.com', '100');

-- ----------------------------
-- Table structure for blog_tag
-- ----------------------------
DROP TABLE IF EXISTS `blog_tag`;
CREATE TABLE `blog_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(32) NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_tag
-- ----------------------------
INSERT INTO `blog_tag` VALUES ('2', '标签二');
INSERT INTO `blog_tag` VALUES ('3', '学习');
INSERT INTO `blog_tag` VALUES ('4', '视频');
INSERT INTO `blog_tag` VALUES ('5', 'php');
INSERT INTO `blog_tag` VALUES ('6', 'html');
INSERT INTO `blog_tag` VALUES ('7', 'css');
INSERT INTO `blog_tag` VALUES ('8', 'js');
INSERT INTO `blog_tag` VALUES ('9', 'tp');
INSERT INTO `blog_tag` VALUES ('10', 'vue');
INSERT INTO `blog_tag` VALUES ('11', 'ui');
INSERT INTO `blog_tag` VALUES ('12', 'jq');
INSERT INTO `blog_tag` VALUES ('13', '标签二1');

-- ----------------------------
-- Table structure for blog_user
-- ----------------------------
DROP TABLE IF EXISTS `blog_user`;
CREATE TABLE `blog_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '0',
  `sex` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of blog_user
-- ----------------------------
INSERT INTO `blog_user` VALUES ('10', 'test1', '', 'test1@qq.com', '0', '0');
INSERT INTO `blog_user` VALUES ('11', 'hezhan', 'e10adc3949ba59abbe56e057f20f883e', 'hezhan@qq.com', '100', '1');
INSERT INTO `blog_user` VALUES ('12', 'hezhan', 'e10adc3949ba59abbe56e057f20f883e', 'hezhan@qq.com', '100', '2');
INSERT INTO `blog_user` VALUES ('13', 'demo1', 'e10adc3949ba59abbe56e057f20f883e', 'demo11@qq.com', '0', '0');
INSERT INTO `blog_user` VALUES ('14', 'demo1', 'e10adc3949ba59abbe56e057f20f883e', 'demo11@qq.com', '0', '0');
INSERT INTO `blog_user` VALUES ('15', 'demo1', '', '', '0', '0');

-- ----------------------------
-- Table structure for blog_webset
-- ----------------------------
DROP TABLE IF EXISTS `blog_webset`;
CREATE TABLE `blog_webset` (
  `webset_id` int(11) NOT NULL AUTO_INCREMENT,
  `webset_name` varchar(45) NOT NULL DEFAULT '' COMMENT '配置项名称',
  `webset_value` varchar(45) NOT NULL DEFAULT '' COMMENT '配置项值',
  `webset_des` varchar(45) NOT NULL DEFAULT '' COMMENT '配置项描述',
  PRIMARY KEY (`webset_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='站点配置';

-- ----------------------------
-- Records of blog_webset
-- ----------------------------
INSERT INTO `blog_webset` VALUES ('1', 'title', '后盾人 人人做后盾', '网站名称');
INSERT INTO `blog_webset` VALUES ('2', 'email', 'houdunwang@163.com', '站长邮箱');
INSERT INTO `blog_webset` VALUES ('3', 'copyright', 'Copyright @ 2018 后盾网', '版权信息');
