<?php

namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\view\View;

class Entry extends Common {

//	  后台默认首页

	public function index() {

		return View::make();

	}


}