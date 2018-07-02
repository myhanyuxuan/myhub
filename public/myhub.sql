/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : myhub

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2018-07-02 18:10:06
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
INSERT INTO `myhub_admin` VALUES ('1', 'luojing', '17ad2d88be777f433619f490234efeff', '0', '14', '0', '0', '1530494274');

-- ----------------------------
-- Table structure for `myhub_gadmin`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_gadmin`;
CREATE TABLE `myhub_gadmin` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `gname` varchar(24) NOT NULL COMMENT '权限组',
  `limits` text COMMENT '权限',
  `addtime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='权限组';

-- ----------------------------
-- Records of myhub_gadmin
-- ----------------------------
INSERT INTO `myhub_gadmin` VALUES ('1', '产品管理员', '1w-jptFfoxjl4gu_JXZWII4drRxPFn--QGW-L23UgOjj7ORmBHGqe_ToP8zBCMfmc2q73skGfufIU6rFy_TJTMBLTuAPB_f3Dzi1AqY6zgWESCkJXxFH4wM29ZNEH6PL22RyngWNTDnGxOAH3ycKCoe3D5A_W-q44_y', '1530524180');
INSERT INTO `myhub_gadmin` VALUES ('2', '数据师', 'OPV2ODRvKHD180MJ55_a4y0GVljcIFxVUxugFo2XXrRZFi8', '1530524207');
INSERT INTO `myhub_gadmin` VALUES ('3', '客服', 'JAN0Ilwj_x.F9HfKm4OVAiyUCorSRMi', '1530524216');
INSERT INTO `myhub_gadmin` VALUES ('6', '权限专员', '', '1530525579');
