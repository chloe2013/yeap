<?php

Class ProductController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Model\Product');
		$this->bread('产品', CPATH);
	}
	
	/**
	 * 列表字段
	 */
	protected static function listsFields()
	{
		return array(
			'id' => 'ID', 
			'top_id' => '顶级', 
			'parent_id' => '上级', 
			'name' => '名称', 
			'identifier' => '别名',
		);
	}
	
	/**
	 * 搜索过滤
	 */
	protected function listSearch()
	{
		if(parent::$input->post('sSearch')) {
			$this->model->where('title', 'like', '%'.parent::$input->post('sSearch').'%');
		}	
	}
	
	/**
	 * 编辑提交
	 */
	protected function editProc()
	{
		$this->model();	
		$this->model->id = parent::$input->post('id');
		$this->model->cate_id = parent::$input->post('cate_id');
		$this->model->identifier = parent::$input->post('identifier');
		$this->model->published = parent::$input->post('published');
		$this->model->title = parent::$input->post('title');
		$this->model->keyword = parent::$input->post('keyword');
		$this->model->body = parent::$input->post('body');
		$this->model->created = time();
		$this->model->save();
	}
	
}

// End;