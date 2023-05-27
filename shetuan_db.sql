/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50051
Source Host           : localhost:3306
Source Database       : shetuan_db

Target Server Type    : MYSQL
Target Server Version : 50051
File Encoding         : 65001

Date: 2018-11-30 22:45:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_admin`
-- ----------------------------
DROP TABLE IF EXISTS `t_admin`;
CREATE TABLE `t_admin` (
  `username` varchar(20) NOT NULL default '',
  `password` varchar(32) default NULL,
  PRIMARY KEY  (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_admin
-- ----------------------------
INSERT INTO `t_admin` VALUES ('a', 'a');

-- ----------------------------
-- Table structure for `t_notice`
-- ----------------------------
DROP TABLE IF EXISTS `t_notice`;
CREATE TABLE `t_notice` (
  `noticeId` int(11) NOT NULL auto_increment COMMENT '公告id',
  `title` varchar(80) NOT NULL COMMENT '标题',
  `content` varchar(5000) NOT NULL COMMENT '公告内容',
  `publishDate` varchar(20) default NULL COMMENT '发布时间',
  PRIMARY KEY  (`noticeId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_notice
-- ----------------------------
INSERT INTO `t_notice` VALUES ('1', 'php社团网站成立了', '<p>同学们喜欢玩什么来这里挑选你们的社团</p>', '2018-11-30 21:39:55');

-- ----------------------------
-- Table structure for `t_postinfo`
-- ----------------------------
DROP TABLE IF EXISTS `t_postinfo`;
CREATE TABLE `t_postinfo` (
  `postInfoId` int(11) NOT NULL auto_increment COMMENT '帖子id',
  `title` varchar(80) NOT NULL COMMENT '帖子标题',
  `content` varchar(5000) NOT NULL COMMENT '帖子内容',
  `hitNum` int(11) NOT NULL COMMENT '浏览量',
  `userObj` varchar(30) NOT NULL COMMENT '发帖人',
  `addTime` varchar(20) default NULL COMMENT '发帖时间',
  PRIMARY KEY  (`postInfoId`),
  KEY `userObj` (`userObj`),
  CONSTRAINT `t_postinfo_ibfk_1` FOREIGN KEY (`userObj`) REFERENCES `t_userinfo` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_postinfo
-- ----------------------------
INSERT INTO `t_postinfo` VALUES ('1', '我想参加社团找谁？', '<p>我喜欢乒乓球，怎么没看到乒乓球的呢？</p>', '55', 'user1', '2018-11-30 21:39:09');
INSERT INTO `t_postinfo` VALUES ('2', '我喜欢打篮球有人和我一样吗', '<p>喜欢打篮球的同学，咱们周末一起去切磋下吧</p>', '9', 'user1', '2018-11-30 22:04:45');

-- ----------------------------
-- Table structure for `t_reply`
-- ----------------------------
DROP TABLE IF EXISTS `t_reply`;
CREATE TABLE `t_reply` (
  `replyId` int(11) NOT NULL auto_increment COMMENT '回复id',
  `postInfoObj` int(11) NOT NULL COMMENT '被回帖子',
  `content` varchar(2000) NOT NULL COMMENT '回复内容',
  `userObj` varchar(30) NOT NULL COMMENT '回复人',
  `replyTime` varchar(20) default NULL COMMENT '回复时间',
  PRIMARY KEY  (`replyId`),
  KEY `postInfoObj` (`postInfoObj`),
  KEY `userObj` (`userObj`),
  CONSTRAINT `t_reply_ibfk_1` FOREIGN KEY (`postInfoObj`) REFERENCES `t_postinfo` (`postInfoId`),
  CONSTRAINT `t_reply_ibfk_2` FOREIGN KEY (`userObj`) REFERENCES `t_userinfo` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_reply
-- ----------------------------
INSERT INTO `t_reply` VALUES ('1', '1', '问管理员吧！', 'user1', '2018-11-30 21:39:21');
INSERT INTO `t_reply` VALUES ('2', '2', '有人和我爱好一样的吗？', 'user1', '2018-11-30 22:27:35');
INSERT INTO `t_reply` VALUES ('3', '1', '我问了管理员，他说马上发布乒乓球社团呢！', 'user2', '2018-11-30 22:44:25');

-- ----------------------------
-- Table structure for `t_shenqing`
-- ----------------------------
DROP TABLE IF EXISTS `t_shenqing`;
CREATE TABLE `t_shenqing` (
  `shenqingId` int(11) NOT NULL auto_increment COMMENT '申请id',
  `shetuanObj` int(11) NOT NULL COMMENT '申请的社团',
  `userObj` varchar(30) NOT NULL COMMENT '申请用户',
  `shenqingTime` varchar(20) default NULL COMMENT '申请时间',
  `shenHe` varchar(20) NOT NULL COMMENT '审核结果',
  `shenqingMemo` varchar(500) default NULL COMMENT '备注',
  PRIMARY KEY  (`shenqingId`),
  KEY `shetuanObj` (`shetuanObj`),
  KEY `userObj` (`userObj`),
  CONSTRAINT `t_shenqing_ibfk_1` FOREIGN KEY (`shetuanObj`) REFERENCES `t_shetuan` (`shetuanId`),
  CONSTRAINT `t_shenqing_ibfk_2` FOREIGN KEY (`userObj`) REFERENCES `t_userinfo` (`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_shenqing
-- ----------------------------
INSERT INTO `t_shenqing` VALUES ('1', '1', 'user1', '2018-11-29 21:38:19', '审核通过', '可以入团');
INSERT INTO `t_shenqing` VALUES ('4', '1', 'user2', '2018-11-30 22:43:40', ' 待审核', '--');

-- ----------------------------
-- Table structure for `t_shetuan`
-- ----------------------------
DROP TABLE IF EXISTS `t_shetuan`;
CREATE TABLE `t_shetuan` (
  `shetuanId` int(11) NOT NULL auto_increment COMMENT '社团id',
  `shetuanName` varchar(20) NOT NULL COMMENT '社团名称',
  `shetuanPhoto` varchar(60) NOT NULL COMMENT '社团图片',
  `yxzyObj` int(11) NOT NULL COMMENT '所在院系专业',
  `bornDate` varchar(20) default NULL COMMENT '成立日期',
  `shetuanDesc` varchar(8000) NOT NULL COMMENT '社团简介',
  `fuzeren` varchar(20) NOT NULL COMMENT '负责人',
  `telephone` varchar(20) NOT NULL COMMENT '联系电话',
  PRIMARY KEY  (`shetuanId`),
  KEY `yxzyObj` (`yxzyObj`),
  CONSTRAINT `t_shetuan_ibfk_1` FOREIGN KEY (`yxzyObj`) REFERENCES `t_yxzy` (`yxzyId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_shetuan
-- ----------------------------
INSERT INTO `t_shetuan` VALUES ('1', '羽毛球社团', 'upload/eb4948adb59acfb204684701b2bb5cba.jpg', '1', '2018-12-27', '<p>本羽毛球社团成立于2018年，参加了多场著名的国际比赛，还取得了不错的名次</p>', '王羲之', '13305830843');
INSERT INTO `t_shetuan` VALUES ('2', '书法社团', 'upload/848a22661840d326d313504edcb3dfce.jpg', '2', '2018-11-22', '<p>大家一起来玩转中国书法，写出一手漂亮的好字</p>', '张国庆', '028-83940843');

-- ----------------------------
-- Table structure for `t_userinfo`
-- ----------------------------
DROP TABLE IF EXISTS `t_userinfo`;
CREATE TABLE `t_userinfo` (
  `user_name` varchar(30) NOT NULL COMMENT 'user_name',
  `password` varchar(30) NOT NULL COMMENT '登录密码',
  `name` varchar(20) NOT NULL COMMENT '姓名',
  `gender` varchar(4) NOT NULL COMMENT '性别',
  `birthDate` varchar(20) default NULL COMMENT '出生日期',
  `userPhoto` varchar(60) NOT NULL COMMENT '用户照片',
  `telephone` varchar(20) NOT NULL COMMENT '联系电话',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `address` varchar(80) default NULL COMMENT '家庭地址',
  `regTime` varchar(20) default NULL COMMENT '注册时间',
  PRIMARY KEY  (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_userinfo
-- ----------------------------
INSERT INTO `t_userinfo` VALUES ('user1', '123', '张晓芬', '女', '2018-11-07', 'upload/db51ad0c6608c0302031738d3472a0a2.jpg', '13985008435', 'xiaofen@163.com', '四川成都红星路12号', '2018-11-30 21:31:26');
INSERT INTO `t_userinfo` VALUES ('user2', '123', '李小倩', '女', '2018-11-15', 'upload/f0c8b64696ffed18c8bc8ae0e134c885.jpg', '13085340842', 'xiaoqian@163.com', '四川南充冰江路aa', '2018-11-30 22:39:06');

-- ----------------------------
-- Table structure for `t_yxzy`
-- ----------------------------
DROP TABLE IF EXISTS `t_yxzy`;
CREATE TABLE `t_yxzy` (
  `yxzyId` int(11) NOT NULL auto_increment COMMENT '院系专业id',
  `yxzyName` varchar(20) NOT NULL COMMENT '院系专业名称',
  PRIMARY KEY  (`yxzyId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_yxzy
-- ----------------------------
INSERT INTO `t_yxzy` VALUES ('1', '信息工程学院软件专业');
INSERT INTO `t_yxzy` VALUES ('2', '信息工程学院电子商务专业');
