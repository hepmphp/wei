CREATE TABLE `web_api_user` (
  `uid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` varchar(15) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '密码md5(md5(pwd)+salt)',
  `salt` char(14) NOT NULL DEFAULT '' COMMENT '14位随机盐',
  `rights` varchar(1000) NOT NULL DEFAULT '' COMMENT '权限，逗号隔开；留空为所有权限',
  `allowed_ip` varchar(200) NOT NULL DEFAULT '' COMMENT '允许的IP，多个用,隔开',
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态:0正常;-1禁用',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='API用户表';

CREATE TABLE `web_api_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` smallint(6) NOT NULL COMMENT '用户ID',
  `token` varchar(32) NOT NULL COMMENT '口令',
  `dateline` int(10) NOT NULL COMMENT '时间戳',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='API登录';


