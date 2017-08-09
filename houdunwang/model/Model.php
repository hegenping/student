<?php
namespace houdunwang\model;
class Model {
//在静态上下文中调用一个不可访问方法时，__callStatic() 会被调用。
	public static function __callStatic( $name, $arguments ) {
//		获取静态绑定后的类名；
		$className = get_called_class();
		//system\model\Arc
		//strrchr字符串截取 变成 \Arc
		//ltrim 去除左边的\ 变成 Arc
		//strtolower 变成 arc
		$table = strtolower(ltrim(strrchr($className,'\\'),'\\'));
		return call_user_func_array([new Base($table),$name],$arguments);
	}
}