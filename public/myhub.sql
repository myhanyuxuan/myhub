/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : myhub

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2018-06-29 18:06:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `myhub_admin`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_admin`;
CREATE TABLE `myhub_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(32) NOT NULL COMMENT '用户名',
  `admin_psd` varchar(32) NOT NULL COMMENT '密码',
  `group_id` varchar(10) DEFAULT NULL COMMENT '会员组id',
  `login_num` varchar(32) DEFAULT NULL COMMENT '登录次数',
  `is_use` varchar(1) DEFAULT NULL COMMENT '是否启用 0启用 1禁用',
  `addtime` int(10) unsigned DEFAULT NULL,
  `oldtime` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of myhub_admin
-- ----------------------------
INSERT INTO `myhub_admin` VALUES ('1', 'luojing', '17ad2d88be777f433619f490234efeff', '0', '13', '0', '0', '1529907855');
