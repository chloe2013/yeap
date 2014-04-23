<?php

Class BannerController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Model\Banner');
		$this->bread('广告', CPATH);
	}
	
	/**
	 * 列表字段
	 */
	protected static function listsFields()
	{
		return array(
			'id' => 'ID', 
			'position' => '位置', 
			'title' => '标题', 
			'content' => '内容', 
			'created' => '创建时间',
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