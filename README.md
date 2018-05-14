# wei
a small php mvc code structure

整体思路
1.app  提供基本的路由和载入功能
2.配置  常规配置信息 数据库配置 路由信息
3.类库

访问
#http://127.0.0.1:10000/index.php/welcome/index 默认控制器方法
#支持分组path/controller/action
#g=group&m=controller&a=action

http://127.0.0.1:10000/index.php?m=index&a=login
http://127.0.0.1:10000/index.php/index/login

路由 采用CI路由
$route['login.html'] = 'index/login';

#Input


#数据库 使用pdo

#自动生成表模型
$db = base\Application::get_db();
Tools::tables_to_model($db);

#模板引擎 php smarty

