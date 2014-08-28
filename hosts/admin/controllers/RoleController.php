<?php

Class RoleController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Role');
		$this->bread('角色', CPATH);
	}

	/**
	 * 列表字段
	 */
	protected static function listsFields()
	{
		return array(
			'id' => array('n' => 'ID'),
			'name' => array('n' => '角色名称'),
		);
	}

	/**
	 * 编辑字段
	 */
	protected static function editFields()
	{
		return array(
			array('name' => 'id', 'title' => 'ID', 'type' => 'input', 'itype' => 'hidden'),
			array('name' => 'name', 'title' => '角色名称', 'type' => 'input'),
		);
	}

	/**
	 * 搜索过滤
	 */
	protected function listSearch()
	{
		if(parent::$input->post('sSearch')) {
			$this->model->where('name', '=', parent::$input->post('sSearch'));
		}
	}

	/**
	 * 编辑提交
	 */
	protected function editProc()
	{
		$this->model();
		$this->model->id = parent::$input->post('id');
		$this->model->name = parent::$input->post('name');
		$this->model->intro = parent::$input->post('intro');
		$this->model->created = time();
		$this->model->save();
	}

}

// End;