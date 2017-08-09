<?php

namespace app\admin\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use system\model\User;

class Login extends Controller {

//	  登陆页面
	public function index() {
		//预先存入数据库用户名和密码
//		$password = password_hash('admin888',PASSWORD_DEFAULT);
//		echo $password;
		if ( IS_POST ) {
			$post = $_POST;
			//验证码错误
			if ( strtolower( $post['captcha'] ) != $_SESSION['captcha'] ) {
				return $this->error( '验证码错误' );
			}
			//用户名不存在
			$data = User::where( "username='{$post['username']}'" )->get();
//			p($_POST);exit;
//			p($data);exit;
			if ($data[0]['username']!=$_POST['username'] ) {

				return $this->error( '用户名不存在' );
			}
			//密码错误
			if( ! password_verify( $post['password'], $data[0]['password'] ) ) {
				return $this->error( '密码错误' );
			}

				//如果勾选了7天免登陆
			if(isset($post['auto'])){
				setcookie(session_name(),session_id(),time() + 7 * 24 * 3600,'/');
			}else{
				setcookie(session_name(),session_id(),0,'/');
			}
			//存session
			$_SESSION['user'] = [
				'uid'      => $data[0]['uid'],
				'username' => $data[0]['username'],
			];

			return $this->setRedirect( '?s=admin/entry/index' )->success( '登陆成功' );
		}


		return View::make();
	}


//	 验证码
	public function captcha() {
		$str     = substr( md5( microtime( true ) ), 0, 3 );
		$captcha = new CaptchaBuilder( $str );
		$captcha->build();
		header( 'Content-type: image/jpeg' );
		$captcha->output();
		//把验证码存入到session
		//把值存入到session
		$_SESSION['captcha'] = strtolower( $captcha->getPhrase() );
	}

//	  	退出
	public function out(){
		session_unset();
		session_destroy();
		return $this->setRedirect('?s=admin/login/index')->success('退出成功');
	}

}