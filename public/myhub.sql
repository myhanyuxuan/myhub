/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : myhub

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2018-07-09 10:02:59
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
  `group_id` varchar(10) DEFAULT '0' COMMENT '会员组id',
  `login_num` varchar(32) DEFAULT '0' COMMENT '登录次数',
  `is_use` varchar(1) DEFAULT '0' COMMENT '是否启用 0启用 1禁用',
  `addtime` int(10) unsigned DEFAULT '0',
  `oldtime` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='管理员表';

-- ----------------------------
-- Records of myhub_admin
-- ----------------------------
INSERT INTO `myhub_admin` VALUES ('1', 'luojing', '17ad2d88be777f433619f490234efeff', '0', '19', '0', '0', '1531100756');
INSERT INTO `myhub_admin` VALUES ('14', 'test', '098f6bcd4621d373cade4e832627b4f6', '10', '5', '0', '1530776226', '1531099752');
INSERT INTO `myhub_admin` VALUES ('15', 'test2', 'ad0234829205b9033196ba818f7a872b', '7', '4', '0', '1530779618', '1531099775');

-- ----------------------------
-- Table structure for `myhub_admin_gadmin`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_admin_gadmin`;
CREATE TABLE `myhub_admin_gadmin` (
  `aid` tinyint(10) unsigned NOT NULL,
  `gid` tinyint(10) unsigned NOT NULL,
  `gname` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of myhub_admin_gadmin
-- ----------------------------
INSERT INTO `myhub_admin_gadmin` VALUES ('14', '10', '管理员');
INSERT INTO `myhub_admin_gadmin` VALUES ('15', '7', '业务员8');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='权限组';

-- ----------------------------
-- Records of myhub_gadmin
-- ----------------------------
INSERT INTO `myhub_gadmin` VALUES ('1', '业务员', 'uMBCgNBazO_Ls-1sAaUARMX808VuzZ4U3EyLPL1VxLKe_dVc9SLDOyQpPNYAFXKnHniywzK2_jFA4O8bZ9vWXh_MkrnKFOjOU3fZU7uhx8jInAlaUYALH0jHBWxYYQ2JSDVHlhnK6-rV1lRL0WwbYPcTQ9V9XPnfzDB', '1530601428');
INSERT INTO `myhub_gadmin` VALUES ('2', '业务员2', '7DzQ9hKjnDud9oph6jkd8zqHuP6_q2gtgH10bJHwWIUjc3nvmAppYL6EEe50CXAasp6wFvAVwcHmLXN0U3f0HrmEq9N3jbq3EGXR4ok5g9e6FshKmsIQj_n2mrV-Z9_8zzw', '1530601437');
INSERT INTO `myhub_gadmin` VALUES ('3', '业务员3', 'WORtuJAhqHiZ7Z8NOURO8SdkfTDC9SSAKjSrKEmREthRr3RQB3lQAukNxl6tM7L', '1530601447');
INSERT INTO `myhub_gadmin` VALUES ('4', '业务员4', 'nytOahOyGSqzrDvwVIy01EQxwLK05rU6SnNk3gcz2iAmzXO43oCBfQW5o7ZxxfL04X_2UHOooNj42qDcE3U5Xw-5R8K4ZsbtRjS3oDO0BLOk4tW11SCtjnH7ns39Bnb0YgCzhjauYzU4UHJkUFPz2Zb', '1530601455');
INSERT INTO `myhub_gadmin` VALUES ('5', '超级管理员-副', 'jtAbzY-Ix7h5NiKo5DTlPytng2OWYzbpeuJNmKEtSbIcIqIOk5DuyM38j2Iv8UDieQ5xpZwcpawgmQtC6bJPclzApMErzMz-yIurkUGypUtOrhENq50rdMvp-bD96cIsg_DeY-CP2U9c74Iw8fBAiHyC1MjNpe0vrSlhmUI_ADxx9h17zHAueLx7QdFClXvungHriVz7Nex86fH6WcJsY_Lt0JBOyD39j2Gv8gHwiL1i1SjMha2AHpyxmKHbUI0gpLBMXKrCem5wIUN_E5M0bjQA-mHmLhNutmMIryYFoADHO46EfWpBp_GD-kZCCiL5wtZu8cfwAf7tAmTH_4J2f5NEc3BA-FQyLAdEzNZuOL_B-may7RQk8iMBdONKak_Jv4-B-BSEsbF', '1530601484');
INSERT INTO `myhub_gadmin` VALUES ('6', '超级管理员-副2', 'OUW0-GO3-n_5VY-VirBsiaQ2PpCkesYncuWo-eHq5iL5Vgpk_lfX_3Et_lULeqc8P-jNG2e4S3ZpTwfJVrhw0RhsColbR3QnLzKZvyRJ4uh6S6irZbhKIlaVqidMUmhOOua32vh7ZBYJnkfIH1Pc_0PbWoPsX-gOaAT4-vcJYkhJVwTvQwgc65jrp3gW_tMaD7RIE0kZ26hrp8jXs2fZCXi7UmftS0RoSngKd4jIP1d3_uEt75Vc6WeLDoe7u3gI-lbp0Jk4Baf8slddWlnJNnaYTiAp_rKbImoHG1gYtxgqUnfJyDbJwjcMC1dYS6kJVqhKTqdnO9S9H4ULuxa83YdvfW4dY6pPYQXfolckOQmiNWtjrg9dXHx', '1530602237');
INSERT INTO `myhub_gadmin` VALUES ('7', '业务员8', 'YaKrS8lsWsI1XrFZotzcjPS9qXw53m8Z-4k-HXh_qpmQpVnsFtpdDsUfSXmPNsgm9RCrM3qhvWrhAI_jdZ9ounIifCamfF5ZsR7kdvjl-GfhAJ6nsdcoN7bfMumjfF5odRuj9nhiwWydPdooNd7lcDoePSbXwJ-nMdFg-Hnevxwl_9xkdVFg-HnevxwhwN-qLV9n9DjUgSqk_FwqLV9n9DjUfWXmP9BbsZqpN6yefWXmP9BbdJyatbmf_auoN96oMoDl-_njQGVkPd4oGIJ', '1530602282');
INSERT INTO `myhub_gadmin` VALUES ('8', '业务员10', 'q_GSBhNOuUpts0qjHkxm-3IHX3o2VM3Qu90CmM1uCO1DtxLpEF0X_IY0W1rPLNY-.Eg', '1530602291');
INSERT INTO `myhub_gadmin` VALUES ('9', '业务员11', 'yGLbCrZbxsdm0Hl1OfiKQN1q2goWUvFbKf2RUrLmUvn4VNh9dWKzm2L_aCsIeDWtxyGp6rPcDd9pJf-KIcSPq3Af2YDI1ZAfuYLNhhH-oNRwFbOO6FVrrWQ7fYT9xtWLvX_bjiBdEz88NcErOrN7_Y9IGK0aIhSuOj0v2hBJ9TMQ2fBd1lDPcZUfZaQ9ieT8znWsDXU9ZuUaLmG4btD90cH71tCaGkCN_JA4OYF4EcReGSyfCpEJZ4P_iJNqRpF_kHTwl5PuiVTYPXP_HJYrprSKqsA87e97wjCN1tv', '1530602298');
INSERT INTO `myhub_gadmin` VALUES ('10', '管理员', '0x-epeh-P3BQh2dlt7HvY2EvP4xDICUhVsGrf4s', '1530852853');
