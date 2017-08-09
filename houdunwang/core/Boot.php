<?php

namespace houdunwang\core;

//  框架启动类
class Boot {

	public static function run(){
		//注册错误处理
		self::handleError();
		//初始化框架
		self::init();
		//执行应用
		self::appRun();

	}

	private static function handleError(){
		$whoops = new \Whoops\Run;
		$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
		$whoops->register();
	}


	private static function appRun(){
		//?s=home/entry/index
		//?s=admin/entry/index
		$s = isset($_GET['s']) ? strtolower($_GET['s']) : 'home/entry/index';
//		字符串转为数组
		$arr = explode('/',$s);
		//p($arr);
//		Array
//		(
//			[0] => home
//			[1] => entry
//			[2] => index
//		)
		//1.把应用比如："home"定义为常量APP
		//2.在houdunwang/view/View.php文件里的View类的make方法组合模板路径，需要用的应用比如:home的名字
		//home是默认应用，有可能为admin后台应用，所以不能写死home
		define('APP',$arr[0]);
		//定义一个CONTROLLER常量
		define('CONTROLLER',$arr[1]);
		//定义一个ACTION常量
		define('ACTION',$arr[2]);
		//组合类名 \app\home\controller\Entry
		$className = "\app\\{$arr[0]}\controller\\" . ucfirst($arr[1]);
		//调用控制器里面的方法
		echo call_user_func_array([new $className,$arr[2]],[]);
//		$s=new Entry;
//		$s->index();
	}

//	  初始化
	private static function init(){
		//开启session
		session_id() || session_start();
		//设置时区
		date_default_timezone_set('PRC');
		//定义是否POST提交的常量
		define('IS_POST',$_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
	}
}