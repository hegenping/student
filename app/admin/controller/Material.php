<?php

namespace app\admin\controller;

use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Material as MaterialModel;

class Material extends Common {

//	 显示素材列表
	public function lists() {
		$data = MaterialModel::get();
		return View::make()->with(compact('data'));
	}


//		增加素材
	public function store() {
		if ( IS_POST ) {
			//返回上传的信息
			$info = $this->upload();
			//把上传之后的信息保存到数据库
			$data = [
				'path' => $info['path'],
				'create_time' => time()
			];
			MaterialModel::save( $data );
			return $this->setRedirect("?s=admin/material/lists")->success('上传成功');
		}

		return View::make();
	}

	private function upload() {
		//创建上传目录
		$dir = 'upload/' . date( 'ymd' );
		is_dir( $dir ) || mkdir($dir, 0777, true);
		//设置上传目录
		$storage=new \Upload\Storage\FileSystem($dir);
		$file=new \Upload\File('upload', $storage );
		//设置上传文件名字唯一
		$new_filename = uniqid();
		$file->setName( $new_filename );

		//设置上传类型和大小
		$file->addValidations( array(

			new \Upload\Validation\Mimetype( [ 'image/png', 'image/gif', 'image/jpeg' ] ),

			new \Upload\Validation\Size( '2M' )
		) );

		//组合数组
		// Access data about the file that has been uploaded
		$data = array(
			'name' => $file->getNameWithExtension(),
			'extension'  => $file->getExtension(),
			'mime'  => $file->getMimetype(),
			'size' => $file->getSize(),
			'md5'  => $file->getMd5(),
			'dimensions' => $file->getDimensions(),
			//自己组合上传之后的完整路径
			'path'=> $dir . '/' . $file->getNameWithExtension(),
		);

		try {
			$file->upload();

			return $data;
		} catch ( \Exception $e ) {

			$errors = $file->getErrors();
			foreach ( $errors as $e ) {
				throw new \Exception( $e );
			}

		}
	}


//		删除
	public function remove() {
		$mid = $_GET['mid'];
		$data = MaterialModel::find($mid);
		//删除文件
		is_file($data['path']) && unlink($data['path']);
		//删除数据库信息
		MaterialModel::where("mid={$mid}")->destory();
		return $this->setRedirect("?s=admin/material/lists")->success('删除成功');

	}
}








