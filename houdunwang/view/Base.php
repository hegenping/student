<?php

namespace houdunwang\view;

class Base {
	//保存分配变量的属性
	private $data = [];
	//模板路径
	private $template;


//	  分配变量
	public function with($data){
		$this->data = $data;
		return $this;
	}


//	  制作模板
	public function make(){
//		../app/home/view/entry/index.php
		$this->template = '../app/' . APP . '/view/' . CONTROLLER . '/' . ACTION . '.php';
		//1.返回当前对象，
		//(1)返给\houdunwang\view\View里面的__callStatic
		//(2)View里面的__callStatic再返回给\app\home\controller\Entry里面的index方法(View::make())
		//(3)Entry里面的index方法又返回给\houdunwang\core\Boot里面的appRun方法，在appRun方法用了echo 输出这个对象
		//2.为了触发__toString
		return $this;
	}


//	  载入模板
	public function __toString() {
		//把键名变为变量名，键值变为变量值 相当于 $data = ['title'=>'我是文章标题'];
		extract($this->data);
		//载入模板
		include $this->template;
		//这个方法必须返回字符串
		return '';
	}
}