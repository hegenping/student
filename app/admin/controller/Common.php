<?php

namespace app\admin\controller;

use houdunwang\core\Controller;

	class Common extends Controller {
		public function __construct() {
		//如果没有登陆
		if(!isset($_SESSION['user'])){
			go('?s=admin/login/index');
		}
	}
}