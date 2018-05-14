# wei
a small php mvc code structure

整体思路
- app  提供基本的路由和载入功能
- 配置  常规配置信息 数据库配置 路由信息
- 类库
```
├─application
│  ├─base            框架核心
│  │  ├─db           数据库查询构造器
│  │  └─session      session支持类
│  ├─configs         配置
│  ├─controllers     控制器
│  │  ├─admin
│  │  └─fenxiao
│  ├─helpers         类库
│  │  ├─Cache
│  │  └─Security
│  ├─models          模型
│  │  ├─Admin
│  │  ├─Jipiao
│  │  ├─Logic
│  │  └─Table
│  └─views           视图
│      ├─admin
│      ├─fenxiao
│      └─test
├─web              日志 静态资源等
│  ├─cache
│  │  └─file
│  └─log
└─vendor           第三方类库
```


1.安装说明
====================================================================
- git clone https://github.com/project007/wei.git
- 配置数据库
- http://wei.local/web/index.php 访问入口

2.路由说明
================================================================================
```
#http://wei.local/index.php/welcome/index 默认控制器方法
访问
http://wei.local/index.php?m=index&a=login
http://wei.local/index.php/index/login
#支持分组 path/controller/action
#g=group&m=controller&a=action

路由 采用CI路由
$route['login.html'] = 'index/login';
更多设置参考
http://codeigniter.org.cn/user_guide/general/routing.html
```
3.类库说明
==============================================================================
```
缓存
安全加密
数组操作
COOKIE
SESSION
CURL
调试类
Email
FTP
Excel
日志类
消息提示
分页类
验证类
```
4.数据库使用说明 使用pdo
===================================================================================
1.模型支持
2.直接快捷链式操作
 添加
 ```
$data = array(
   'user_id'=>1,
   'platform_id'=>1000,
   'username'=>'zhangshan',
   'ip'=>'127.0.0.1',
   'm'=>'m',
   'a'=>'a',
   'addtime'=>time(),
);
$res = D('ga_admin_log')->insert($data);

```
删除
```
 D("ga_admin_log")->delete(array('id'=>986));
```
修改
```
$res = D('ga_admin_log')->update(['username'=>'aaaaaaaaaa'],['id'=>1060]);
```
查询
//1.字符串条件 id=1 and time>1 and time< 2  name like %xxx%
//2.数组条件  array("xxx")
```
$where = array(
//    'id'=>[1,2,3],// in查询
//    'id >' => 1,//添加查询
//    'username'=>'',
//    'addtime <'=>'123456',//时间范围查询
//    'addtime >'=>'789465',
    'username ~'=>'z',//like查询
);
多条
$all = D("ga_admin_log")->where($where)->group_by('id')->limit(0,3)->fetchAll();
单条
$one = D("ga_admin_log")->where($where)->group_by('id')->limit(1)->fetch();
```

调试
var_dump(D('ga_admin_log')->getLastSql());


5.模板引擎 php smarty 更多引擎请使用第三方类库引入

