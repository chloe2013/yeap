<?php

Class CategoryController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Category');
		$this->bread('分类', CPATH);
	}

	/**
	 * 列表字段
	 */
	protected static function listsFields()
	{
		return array(
			'id' => array('n' => 'ID', ),
			'top_id' => array('n' => '顶级',),
			'parent_id' => array('n' => '上级',),
			'name' => array('n' => '名称', ),
			'identifier' => array('n' => '别名',),
		);
	}

	/**
	 * 编辑字段
	 */
	protected static function editFields()
	{
		return array(
			array('name' => 'id', 'title' => 'ID', 'type' => 'input', 'itype' => 'hidden'),
			array('name' => 'top_id', 'title' => '顶级', 'type' => 'input', 'itype' => 'hidden'),
			array('name' => 'parent_id', 'title' => '上级', 'type' => 'select'),
			array('name' => 'name', 'title' => '名称', 'type' => 'input'),
			array('name' => 'identifier', 'title' => '别名', 'type' => 'input', 'tip' => '英文,seo地址用'),
		);
	}

	/**
	 * 搜索过滤
	 */
	protected function listSearch()
	{
		if(parent::$input->post('sSearch')) {
			$this->model->where('name', 'like', '%'.parent::$input->post('sSearch').'%');
		}
	}

	/**
	 * 编辑提交
	 */
	protected function editProc()
	{
		$this->model();
		$this->model->id = parent::$input->post('id');
		$this->model->top_id = parent::$input->post('top_id');
		$this->model->parent_id = parent::$input->post('parent_id');
		$this->model->name = parent::$input->post('name');
		$this->model->identifier = parent::$input->post('identifier');
		$this->model->save();
	}

}

// End;