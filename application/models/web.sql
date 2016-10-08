CREATE TABLE `web_api_user` (
  `uid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '�û�ID',
  `username` varchar(15) NOT NULL DEFAULT '' COMMENT '�û���',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '����md5(md5(pwd)+salt)',
  `salt` char(14) NOT NULL DEFAULT '' COMMENT '14λ�����',
  `rights` varchar(1000) NOT NULL DEFAULT '' COMMENT 'Ȩ�ޣ����Ÿ���������Ϊ����Ȩ��',
  `allowed_ip` varchar(200) NOT NULL DEFAULT '' COMMENT '�����IP�������,����',
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '���ʱ��',
  `flag` tinyint(4) NOT NULL DEFAULT '0' COMMENT '״̬:0����;-1����',
  PRIMARY KEY (`uid`),
  KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='API�û���';

CREATE TABLE `web_api_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����ID',
  `uid` smallint(6) NOT NULL COMMENT '�û�ID',
  `token` varchar(32) NOT NULL COMMENT '����',
  `dateline` int(10) NOT NULL COMMENT 'ʱ���',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT 'ip��ַ',
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '���ʱ��',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='API��¼';


