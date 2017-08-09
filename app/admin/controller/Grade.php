<?php

namespace app\admin\controller;
use houdunwang\core\Controller;
use houdunwang\view\View;
use system\model\Grade as GradeModel;

class Grade extends Common {

//	  班级列表
	public function lists(){
		$data = GradeModel::get();
		return View::make()->with(compact('data'));
	}


//	 添加
	public function store(){
		if(IS_POST){
			GradeModel::save($_POST);
			return $this->setRedirect('?s=admin/grade/lists')->success('添加成功');
		}
				return View::make();
	}

//	 编辑
	public function update(){
		$gid = $_GET['gid'];
		if(IS_POST){
			GradeModel::where("gid={$gid}")->update($_POST);
			return $this->setRedirect('?s=admin/grade/lists')->success('修改成功');

		}
		$oldData = GradeModel::find($gid);
		return View::make()->with(compact('oldData'));
	}

//	  删除
	public function remove(){
		GradeModel::where("gid={$_GET['gid']}")->destory();
		return $this->setRedirect('?s=admin/grade/lists')->success('删除成功');
	}
}