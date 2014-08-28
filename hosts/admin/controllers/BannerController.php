<?php

Class BannerController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Banner');
		$this->bread('广告', CPATH);
	}

	/**
	 * 列表字段
	 */
	protected static function listsFields()
	{
		return array(
			'id' => array('n' => 'ID',),
			'position' => array('n' => '位置'),
			'title' => array('n' => '标题'),
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
			array('name' => 'title', 'title' => '标题', 'type' => 'input'),
			array('name' => 'position', 'title' => '位置', 'type' => 'input'),
			array('name' => 'content', 'title' => '内容', 'type' => 'textarea'),
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
		$article = new $this->model;
		$article->id = (int)parent::$input->post('id');
		$article->position = parent::$input->post('position');
		$article->title = parent::$input->post('title');
		$article->content = parent::$input->post('content');
		$article->created = time();
		$article->save();
	}

}

// End;