DROP TABLE IF EXISTS `shop_admin`;
CREATE TABLE IF NOT EXISTS `shop_admin`(
  `adminid` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '管理员主键id',
  `adminuser` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `adminpass` CHAR(64) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `adminemail` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '管理员邮箱',
  `logintime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '登录时间',
  `loginip` BIGINT NOT NULL DEFAULT '0' COMMENT '登录ip',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY(`adminid`),
  UNIQUE shop_admin_adminuser_adminpass(`adminuser`,`adminpass`),
  UNIQUE shop_admin_adminuser_adminemail(`adminuser`,`adminemail`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';

INSERT INTO  `shop_admin`(adminuser,adminpass,adminemail,createtime) VALUES('admin',md5('123'),'test@qq.com',UNIX_TIMESTAMP());

-- alter table `shop_admin` modify adminpass CHAR(64) NOT NULL DEFAULT '' comment '改变管理员密码加密形式';

DROP TABLE IF EXISTS `shop_user`;
CREATE TABLE IF NOT EXISTS `shop_user`(
  `userid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户主键id',
  `username` VARCHAR(32) NOT NULL DEFAULT '',
  `userpass` CHAR(64) NOT NULL DEFAULT '',
  `useremail` VARCHAR(100) NOT NULL DEFAULT '',
  `openid` char(32) not null DEFAULT '0',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
  UNIQUE shop_user_username_userpass(`username`,`userpass`),
  UNIQUE shop_user_useremail_userpass(`useremail`,`userpass`),
  PRIMARY KEY(`userid`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';

-- alter table `shop_user` modify userpass CHAR(64) NOT NULL DEFAULT '' comment '改变密码加密形式';
-- alter table shop_user add `openid` char(32) not null DEFAULT '0';

DROP TABLE IF EXISTS `shop_profile`;
CREATE TABLE IF NOT EXISTS `shop_profile`(
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户详细信息id',
  `truename` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `age` TINYINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` ENUM('0','1','2') NOT NULL DEFAULT '0' COMMENT '性别',
  `birthday` date NOT NULL DEFAULT '2017-02-10' COMMENT '生日',
  `nickname` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `company` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '公司',
  `userid` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户的ID',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建日期',
  PRIMARY KEY(`id`),
  UNIQUE shop_profile_userid(`userid`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';

DROP TABLE IF EXISTS `shop_category`;
CREATE TABLE IF NOT EXISTS `shop_category`(
  `cateid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT  COMMENT '商品分类id',
  `title` VARCHAR(32) NOT NULL DEFAULT '',
  `parentid` BIGINT UNSIGNED NOT NULL DEFAULT '0',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
   adminid int unsigned not null default '0' comment '添加的管理员id',
  PRIMARY KEY(`cateid`),
  KEY shop_category_cateid_parentid(`parentid`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';

-- alter table shop_category add adminid int unsigned not null default '0' comment '添加的管理员id';

DROP TABLE IF EXISTS  `shop_product`;
CREATE TABLE IF NOT EXISTS  `shop_product`(
  `productid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cateid` BIGINT UNSIGNED NOT NULL DEFAULT '0',
  `title` VARCHAR(200) NOT NULL DEFAULT '',
  `description` TEXT,
  `num` BIGINT UNSIGNED NOT NULL DEFAULT '0',
  `price` DECIMAL(10,2) NOT NULL DEFAULT '00000000.00',
  `cover` VARCHAR(200) NOT NULL DEFAULT '' COMMENT '封面图片',
  `pics` TEXT COMMENT '多张图片转换成json',
  `issale` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '1代表促销',
  `saleprice` DECIMAL(10,2) NOT NULL DEFAULT '00000000.00' COMMENT '促销价格',
  `ishot` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否上架,1代表上架',
  `ison` ENUM('0','1') NOT NULL DEFAULT '1' COMMENT '是否热卖,1代表热卖',
  `istui` ENUM('0','1') NOT NULL DEFAULT '0' COMMENT '是否推荐,1代表推荐',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
  shop_product add updatetime int unsigned not null default '0' comment '商品更新时间',
  PRIMARY KEY(`productid`),
  KEY shop_product_cateid(`cateid`)
)ENGINE InnoDB DEFAULT CHARSET='utf8';

-- alter table shop_product add updatetime int unsigned not null default '0' comment '商品更新时间';
-- alter table shop_product change `desc`  description TEXT;

DROP TABLE IF EXISTS  `shop_cart`;
CREATE TABLE IF NOT EXISTS  `shop_cart`(
  `cartid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `productid` BIGINT UNSIGNED NOT NULL DEFAULT '0',
  `productnum` INT UNSIGNED NOT NULL DEFAULT '0',
  `price` DECIMAL(10,2) NOT NULL DEFAULT '0.00',
  `userid` BIGINT UNSIGNED NOT NULL DEFAULT '0',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
  updatetime int unsigned not null default '0' comment '购物车商品更新时间',
  KEY shop_cart_productid(`productid`),
  KEY shop_cart_userid(`userid`)
)ENGINE=InnoDB DEFAULT CHARSET='utf8';

-- alter table shop_cart add updatetime int unsigned not null default '0' comment '购物车商品更新时间';
-- alter table shop_cart modify updatetime int unsigned not null default '0' comment '购物车商品更新时间';

DROP TABLE IF EXISTS  `shop_order`;
CREATE TABLE IF NOT EXISTS  `shop_order`(
  `orderid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userid` BIGINT UNSIGNED NOT NULL DEFAULT '0',
  `addressid` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT '收货地址',
  `amount` DECIMAL(10,2) NOT NULL DEFAULT'0.00' COMMENT '订单总价',
  `status` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '订单状态',
  `expressid` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '快递方式',
  `expressno` VARCHAR(50) NOT NULL DEFAULT '' COMMENT '快递单号来查询快递状态',
  `tradeno` VARCHAR(100) NOT NULL DEFAULT '',
  `tradeext` TEXT,
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updatetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '订单更新时间',
  KEY shop_order_userid(`userid`),
  KEY shop_order_addressid(`addressid`),
  KEY shop_order_expressid(`expressid`)
)ENGINE InnoDB DEFAULT CHARSET='utf8';

DROP TABLE IF EXISTS  `shop_order_detail`;
CREATE TABLE IF NOT EXISTS  `shop_order_detail`(
  `detailid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY COMMENT '商品详情',
  `productid`BIGINT UNSIGNED NOT NULL DEFAULT '0',
  `price` DECIMAL(10,2) NOT NULL DEFAULT '0',
  `productnum` INT UNSIGNED NOT NULL DEFAULT '0',
  `orderid` BIGINT UNSIGNED NOT NULL DEFAULT '0',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
  KEY shop_order_detail_productid(`productid`),
  KEY shop_order_detail_orderid(`orderid`)
)ENGINE InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS  `shop_address`;
CREATE TABLE IF NOT EXISTS  `shop_address`(
  `addressid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `firstname` VARCHAR(32) NOT NULL DEFAULT '',
  `lastname` VARCHAR(32) NOT NULL DEFAULT '',
  `company` VARCHAR(100) NOT NULL DEFAULT '',
  `address` TEXT,
  `postcode` CHAR(6) NOT NULL DEFAULT '',
  `email` VARCHAR(100) NOT NULL DEFAULT '',
  `telephone` VARCHAR(15) NOT NULL DEFAULT '',
  `userid` BIGINT UNSIGNED NOT NULL DEFAULT '0',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0',
  KEY shop_address_userid(`userid`)
)ENGINE InnoDB DEFAULT CHARSET='utf8';

DROP TABLE IF EXISTS  `shop_picture`;
CREATE TABLE IF NOT EXISTS  `shop_picture`(
  `pictureid` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(32) NOT NULL DEFAULT '',
  `piccomment` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '图片评价',
  `piccates` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '图片分类',
  `pictures` TEXT COMMENT '所有图片存进json',
  `createtime` INT UNSIGNED NOT NULL DEFAULT '0'
)ENGINE InnoDB DEFAULT CHARSET='utf8';

-- alter table `shop_picture` add `createtime` INT UNSIGNED NOT NULL DEFAULT '0' comment "图片创建时间";

/*
mysql :  inet_aton('192.168.1.101');    ip转int
         select inet_ntoa(3232235877);       int转ip
php :   echo ip2long('192.168.1.38'); ip转int    存入时候
        long2ip();                    int转ip    读取时候
        获取IP $reIP=$_SERVER["REMOTE_ADDR"];

 */