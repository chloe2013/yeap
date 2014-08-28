<?php

Class AuthController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Auth');
		$this->bread('权限节点', CPATH);
	}

	/**
	 * 列表字段
	 */
	protected static function listsFields()
	{
		return array(
			'id' => array('n' => 'ID'),
			'parent_id' => array('n' => '上一级'),
			'name' => array('n' => '节点名称'),
			'rule' => array('n' => '规则'),
			'is_show' => array('n' => '是否显示'),
			'url' => array('n' => 'url'),
			'icon' => array('n' => 'icon'),
		);
	}

	/**
	 * 编辑字段
	 */
	protected static function editFields()
	{
		return array(
			array('name' => 'id', 'title' => 'ID', 'type' => 'input', 'itype' => 'hidden'),
			array('name' => 'name', 'title' => '节点名称', 'type' => 'input'),
			array('name' => 'rule', 'title' => '规则', 'type' => 'input'),
			array('name' => 'is_show', 'title' => '是否显示', 'type' => 'switch'),
			array('name' => 'url', 'title' => '链接地址', 'type' => 'input'),
			array('name' => 'icon', 'title' => 'icon class', 'type' => 'input'),
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
		$this->model->parent_id = (int)parent::$input->post('parent_id');
		$this->model->name = parent::$input->post('name');
		$this->model->rule = parent::$input->post('rule');
		$this->model->is_show = parent::$input->post('is_show') === 'on' ? 1 : 0;
		$this->model->url = parent::$input->post('url');
		$this->model->icon = parent::$input->post('icon');
		$this->model->save();
	}

}

// End;