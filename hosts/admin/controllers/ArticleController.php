<?php

Class ArticleController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Model\Article');
		$this->bread('文章', CPATH);
	}
	
	/**
	 * 列表字段
	 */
	protected static function listsFields()
	{
		return array(
			'id' => array('n' => 'ID',), 
			'cate_id' => array('n' => '分类'), 
			'title' => array('n' => '标题'), 
			'identifier' => array('n' => '别名'),  
			'published' => array('n' => '状态'), 
			'modified' => array('n' => '更新时间'), 
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
			array('name' => 'identifier', 'title' => '别名', 'type' => 'input', 'tip' => '英文,seo地址用'),
			array('name' => 'cate_id', 'title' => '分类', 'type' => 'select'),
			array('name' => 'published', 'title' => '激活状态', 'type' => 'switch'),
			array('name' => 'body', 'title' => '内容', 'type' => 'textarea'),
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
		$article->cate_id = (int)parent::$input->post('cate_id');
		$article->identifier = parent::$input->post('identifier');
		$article->published = parent::$input->post('published') === 'on' ? 1 : 0;
		$article->title = parent::$input->post('title');
		$article->keyword = parent::$input->post('keyword');
		$article->body = parent::$input->post('body');
		$article->created = time();
		$article->modified = time();
		$article->save();
	}
	
}

// End;