/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : myhub

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2018-07-16 13:32:25
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
INSERT INTO `myhub_admin` VALUES ('1', 'luojing', '17ad2d88be777f433619f490234efeff', '0', '21', '0', '0', '1531705700');
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限管理员表';

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
INSERT INTO `myhub_gadmin` VALUES ('4', '业务员4', 'nytOahOyGSqzrDvwVIy01EQxwLK05rU6SnNk3gcz2iAmzXO43oCBfQW5o7ZxxfL04X_2UHOooNj42qDcE3U5Xw-5R8K4ZsbtRjS3oDO0BLOk4tW11SCtjnH7ns39Bnb0YgCzhjauYzU4UHJkUFPz2Zb', '1530601455');
INSERT INTO `myhub_gadmin` VALUES ('5', '超级管理员-副', 'jtAbzY-Ix7h5NiKo5DTlPytng2OWYzbpeuJNmKEtSbIcIqIOk5DuyM38j2Iv8UDieQ5xpZwcpawgmQtC6bJPclzApMErzMz-yIurkUGypUtOrhENq50rdMvp-bD96cIsg_DeY-CP2U9c74Iw8fBAiHyC1MjNpe0vrSlhmUI_ADxx9h17zHAueLx7QdFClXvungHriVz7Nex86fH6WcJsY_Lt0JBOyD39j2Gv8gHwiL1i1SjMha2AHpyxmKHbUI0gpLBMXKrCem5wIUN_E5M0bjQA-mHmLhNutmMIryYFoADHO46EfWpBp_GD-kZCCiL5wtZu8cfwAf7tAmTH_4J2f5NEc3BA-FQyLAdEzNZuOL_B-may7RQk8iMBdONKak_Jv4-B-BSEsbF', '1530601484');
INSERT INTO `myhub_gadmin` VALUES ('6', '超级管理员-副2', 'OUW0-GO3-n_5VY-VirBsiaQ2PpCkesYncuWo-eHq5iL5Vgpk_lfX_3Et_lULeqc8P-jNG2e4S3ZpTwfJVrhw0RhsColbR3QnLzKZvyRJ4uh6S6irZbhKIlaVqidMUmhOOua32vh7ZBYJnkfIH1Pc_0PbWoPsX-gOaAT4-vcJYkhJVwTvQwgc65jrp3gW_tMaD7RIE0kZ26hrp8jXs2fZCXi7UmftS0RoSngKd4jIP1d3_uEt75Vc6WeLDoe7u3gI-lbp0Jk4Baf8slddWlnJNnaYTiAp_rKbImoHG1gYtxgqUnfJyDbJwjcMC1dYS6kJVqhKTqdnO9S9H4ULuxa83YdvfW4dY6pPYQXfolckOQmiNWtjrg9dXHx', '1530602237');
INSERT INTO `myhub_gadmin` VALUES ('7', '业务员8', 'YaKrS8lsWsI1XrFZotzcjPS9qXw53m8Z-4k-HXh_qpmQpVnsFtpdDsUfSXmPNsgm9RCrM3qhvWrhAI_jdZ9ounIifCamfF5ZsR7kdvjl-GfhAJ6nsdcoN7bfMumjfF5odRuj9nhiwWydPdooNd7lcDoePSbXwJ-nMdFg-Hnevxwl_9xkdVFg-HnevxwhwN-qLV9n9DjUgSqk_FwqLV9n9DjUfWXmP9BbsZqpN6yefWXmP9BbdJyatbmf_auoN96oMoDl-_njQGVkPd4oGIJ', '1530602282');
INSERT INTO `myhub_gadmin` VALUES ('8', '业务员10', 'q_GSBhNOuUpts0qjHkxm-3IHX3o2VM3Qu90CmM1uCO1DtxLpEF0X_IY0W1rPLNY-.Eg', '1530602291');
INSERT INTO `myhub_gadmin` VALUES ('9', '业务员11', 'yGLbCrZbxsdm0Hl1OfiKQN1q2goWUvFbKf2RUrLmUvn4VNh9dWKzm2L_aCsIeDWtxyGp6rPcDd9pJf-KIcSPq3Af2YDI1ZAfuYLNhhH-oNRwFbOO6FVrrWQ7fYT9xtWLvX_bjiBdEz88NcErOrN7_Y9IGK0aIhSuOj0v2hBJ9TMQ2fBd1lDPcZUfZaQ9ieT8znWsDXU9ZuUaLmG4btD90cH71tCaGkCN_JA4OYF4EcReGSyfCpEJZ4P_iJNqRpF_kHTwl5PuiVTYPXP_HJYrprSKqsA87e97wjCN1tv', '1530602298');
INSERT INTO `myhub_gadmin` VALUES ('10', '管理员', '0x-epeh-P3BQh2dlt7HvY2EvP4xDICUhVsGrf4s', '1530852853');

-- ----------------------------
-- Table structure for `myhub_stock_area`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_stock_area`;
CREATE TABLE `myhub_stock_area` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `area_name` varchar(32) NOT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='进销存-客户地区';

-- ----------------------------
-- Records of myhub_stock_area
-- ----------------------------
INSERT INTO `myhub_stock_area` VALUES ('1', '温江区');
INSERT INTO `myhub_stock_area` VALUES ('2', '锦江区');
INSERT INTO `myhub_stock_area` VALUES ('3', '青羊区');

-- ----------------------------
-- Table structure for `myhub_stock_class`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_stock_class`;
CREATE TABLE `myhub_stock_class` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(32) NOT NULL COMMENT '分类名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='进销存-产品大类';

-- ----------------------------
-- Records of myhub_stock_class
-- ----------------------------
INSERT INTO `myhub_stock_class` VALUES ('1', '玫瑰');
INSERT INTO `myhub_stock_class` VALUES ('2', '百合');
INSERT INTO `myhub_stock_class` VALUES ('3', '向日葵');
INSERT INTO `myhub_stock_class` VALUES ('4', '康乃馨');

-- ----------------------------
-- Table structure for `myhub_stock_data`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_stock_data`;
CREATE TABLE `myhub_stock_data` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `bid` varchar(10) NOT NULL COMMENT '产品编码',
  `p_name` varchar(32) NOT NULL COMMENT '产品名称',
  `class_id` varchar(32) NOT NULL DEFAULT '0' COMMENT '大类id',
  `unit_id` varchar(32) NOT NULL DEFAULT '0' COMMENT '单位id',
  `spec_id` varchar(32) NOT NULL DEFAULT '0' COMMENT '规格id',
  `ctime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `etime` int(10) unsigned NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='进销存-产品资料';

-- ----------------------------
-- Records of myhub_stock_data
-- ----------------------------
INSERT INTO `myhub_stock_data` VALUES ('1', 'BH000001', '多头百合粉（5头）', '2', '5', '13', '1531386705', '1531389597');
INSERT INTO `myhub_stock_data` VALUES ('2', 'MG000002', '红玫瑰', '1', '6', '16', '1531388008', '1531389573');
INSERT INTO `myhub_stock_data` VALUES ('3', 'KN000003', '红康', '4', '6', '1', '1531389715', '0');

-- ----------------------------
-- Table structure for `myhub_stock_kehu`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_stock_kehu`;
CREATE TABLE `myhub_stock_kehu` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `kehu_name` varchar(32) NOT NULL,
  `area_id` tinyint(10) unsigned NOT NULL,
  `address` varchar(45) NOT NULL,
  `tel_phone` varchar(32) NOT NULL,
  `tel_name` varchar(32) NOT NULL,
  `tel_phone2` varchar(32) DEFAULT NULL,
  `qq` varchar(32) DEFAULT NULL,
  `weixin` varchar(32) DEFAULT NULL,
  `ctime` int(10) unsigned NOT NULL,
  `etime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='进销存-客户资料';

-- ----------------------------
-- Records of myhub_stock_kehu
-- ----------------------------
INSERT INTO `myhub_stock_kehu` VALUES ('1', '德胜路店', '1', '德盛路24号附4号1层', '028-86651085', '李旭', null, null, null, '1531467258', '1531468485');
INSERT INTO `myhub_stock_kehu` VALUES ('2', '李四', '2', '成都清江区ssss', '1522882578', '啊啊啊', '1522882578', '13039964533', 'df3262f6ddf', '1531467590', '1531468498');

-- ----------------------------
-- Table structure for `myhub_stock_sales`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_stock_sales`;
CREATE TABLE `myhub_stock_sales` (
  `id` tinyint(8) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `sales_id` varchar(32) NOT NULL DEFAULT '0' COMMENT '销售人员',
  `stock_id` varchar(32) NOT NULL DEFAULT '0' COMMENT '出货仓库',
  `p_id` varchar(32) DEFAULT '0' COMMENT '配送人',
  `kehu_name` varchar(32) NOT NULL COMMENT '客户',
  `tel_phone` varchar(32) NOT NULL COMMENT '客户电话',
  `address` varchar(45) NOT NULL COMMENT '客户地址',
  `tel_name` varchar(32) NOT NULL COMMENT '联系人',
  `total_price` varchar(32) NOT NULL DEFAULT '0.00' COMMENT '合计金额',
  `pay_price` varchar(32) NOT NULL DEFAULT '0.00' COMMENT '实付金额',
  `ctime` int(10) unsigned NOT NULL,
  `etime` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='进销存管理-销售';

-- ----------------------------
-- Records of myhub_stock_sales
-- ----------------------------

-- ----------------------------
-- Table structure for `myhub_stock_spec`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_stock_spec`;
CREATE TABLE `myhub_stock_spec` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `spec_name` varchar(32) NOT NULL COMMENT '规格名称',
  `ctime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `etime` int(10) unsigned NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='进销存-产品规格';

-- ----------------------------
-- Records of myhub_stock_spec
-- ----------------------------
INSERT INTO `myhub_stock_spec` VALUES ('1', '紫红色', '1531379311', '0');
INSERT INTO `myhub_stock_spec` VALUES ('2', '黄色', '1531379317', '0');
INSERT INTO `myhub_stock_spec` VALUES ('3', '浅紫色', '1531379323', '0');
INSERT INTO `myhub_stock_spec` VALUES ('4', '浅蓝色', '1531379329', '0');
INSERT INTO `myhub_stock_spec` VALUES ('5', '绿色', '1531379334', '0');
INSERT INTO `myhub_stock_spec` VALUES ('6', '粉色', '1531379340', '0');
INSERT INTO `myhub_stock_spec` VALUES ('7', '紫色', '1531379345', '0');
INSERT INTO `myhub_stock_spec` VALUES ('8', '水粉色', '1531379351', '0');
INSERT INTO `myhub_stock_spec` VALUES ('9', '橙色红边', '1531379356', '0');
INSERT INTO `myhub_stock_spec` VALUES ('10', '香槟色', '1531379363', '0');
INSERT INTO `myhub_stock_spec` VALUES ('11', '蓝色', '1531379368', '0');
INSERT INTO `myhub_stock_spec` VALUES ('12', '橙黄色', '1531379373', '0');
INSERT INTO `myhub_stock_spec` VALUES ('13', '白色', '1531379378', '0');
INSERT INTO `myhub_stock_spec` VALUES ('14', '黄底红边', '1531379383', '0');
INSERT INTO `myhub_stock_spec` VALUES ('15', '桃红色', '1531379389', '0');
INSERT INTO `myhub_stock_spec` VALUES ('16', '红色', '1531389555', '0');

-- ----------------------------
-- Table structure for `myhub_stock_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_stock_supplier`;
CREATE TABLE `myhub_stock_supplier` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(32) NOT NULL,
  `address` varchar(45) NOT NULL,
  `tel_phone` varchar(32) NOT NULL,
  `tel_name` varchar(32) NOT NULL,
  `tel_phone2` varchar(32) DEFAULT NULL,
  `qq` varchar(32) DEFAULT NULL,
  `weixin` varchar(32) DEFAULT NULL,
  `ctime` int(10) unsigned NOT NULL,
  `etime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='进销存-供货商资料';

-- ----------------------------
-- Records of myhub_stock_supplier
-- ----------------------------
INSERT INTO `myhub_stock_supplier` VALUES ('1', '天天鲜花配送中心', '锦江区华星路', '86911061', '岳老师', null, null, null, '1531462647', '0');
INSERT INTO `myhub_stock_supplier` VALUES ('2', '万福市场', '万福花市产业园', '18408256831', '吴仕博', null, null, null, '1531462801', '0');
INSERT INTO `myhub_stock_supplier` VALUES ('4', '罗靖', '成都温江区', '13880520583', '长江', '3073598', '1303996433', 'luo1303996433', '1531463555', '1531464737');

-- ----------------------------
-- Table structure for `myhub_stock_unit`
-- ----------------------------
DROP TABLE IF EXISTS `myhub_stock_unit`;
CREATE TABLE `myhub_stock_unit` (
  `id` tinyint(10) unsigned NOT NULL AUTO_INCREMENT,
  `com_name` varchar(32) NOT NULL COMMENT '单位名称',
  `cap_name` varchar(32) NOT NULL COMMENT '单位容量',
  `ctime` int(10) unsigned NOT NULL COMMENT '添加时间',
  `etime` int(10) unsigned NOT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='进销存-计量单位';

-- ----------------------------
-- Records of myhub_stock_unit
-- ----------------------------
INSERT INTO `myhub_stock_unit` VALUES ('1', '1kg/扎', '1kg', '1531377066', '0');
INSERT INTO `myhub_stock_unit` VALUES ('2', '8支/扎', '8-12支', '1531377080', '0');
INSERT INTO `myhub_stock_unit` VALUES ('3', '5支/扎', '5支', '1531377090', '1531377876');
INSERT INTO `myhub_stock_unit` VALUES ('4', '1支/扎', '1支', '1531377100', '0');
INSERT INTO `myhub_stock_unit` VALUES ('5', '10支/扎', '10支', '1531377119', '0');
INSERT INTO `myhub_stock_unit` VALUES ('6', '20支/扎', '20支', '1531377127', '0');
