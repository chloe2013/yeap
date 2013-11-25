<?php
namespace Admin\Controller;

use Admin\Core\Controller;

Class Article extends Controller
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
			'id' => 'ID', 
			'cate_id' => '分类', 
			'title' => '标题', 
			'identifier' => '别名', 
			'published' => '状态',
			'modified' => '更新时间',
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
		$article = new MArticle();	
		$article->id = parent::$input->post('id');
		$article->cate_id = parent::$input->post('cate_id');
		$article->identifier = parent::$input->post('identifier');
		$article->published = parent::$input->post('published');
		$article->title = parent::$input->post('title');
		$article->keyword = parent::$input->post('keyword');
		$article->body = parent::$input->post('body');
		$article->created = time();
		$article->modified = time();
		$article->save();
	}
	
}

// End;