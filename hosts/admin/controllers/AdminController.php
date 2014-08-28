<?php

use Yeap\Security;

Class AdminController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Admin');
		$this->bread('管理员', CPATH);
	}

	/**
	 * 列表字段
	 */
	protected static function listsFields()
	{
		return array(
			'id' => array('n' => 'ID'),
			'uid' => array('n' => '用户名'),
			'name' => array('n' => '姓名'),
			'email' => array('n' => '邮箱'),
			'tel' => array('n' => '电话'),
			'created' => array('n' => '创建时间'),
		);
	}

	/**
	 * 编辑字段
	 */
	protected static function editFields()
	{
		return array(
			array('name' => 'id', 'title' => 'ID', 'type' => 'input', 'itype' => 'hidden'),
			array('name' => 'uid', 'title' => '用户名', 'type' => 'input', 'tip' => '6-16位数字、英文、下划线组成'),
			array('name' => 'password', 'title' => '密码', 'type' => 'input', 'itype' => 'password'),
			array('name' => 'password2', 'title' => '确认密码', 'type' => 'input', 'itype' => 'password'),
			array('name' => 'name', 'title' => '姓名', 'type' => 'input'),
			array('name' => 'email', 'title' => '邮箱', 'type' => 'input'),
			array('name' => 'tel', 'title' => '电话', 'type' => 'input'),
			array('name' => 'role_id', 'title' => '角色', 'type' => 'select'),
		);
	}

	/**
	 * 搜索过滤
	 */
	protected function listSearch()
	{
		if(parent::$input->post('sSearch')) {
			$this->model->where('uid', '=', parent::$input->post('sSearch'));
		}
	}

	/**
	 * 编辑提交
	 */
	protected function editProc()
	{
		$this->model();
		$this->model->id = parent::$input->post('id');
		$this->model->uid = parent::$input->post('uid');
		$this->model->password = Security::password(parent::$input->post('password'));
		$this->model->name = parent::$input->post('name');
		$this->model->email = parent::$input->post('email');
		$this->model->tel = parent::$input->post('tel');
		$this->model->created = time();
		$this->model->save();
	}

}

// End;