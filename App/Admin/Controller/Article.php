<?php
namespace Admin\Controller;

use Admin\Core\Controller;
use Model\Article as MArticle;

Class Article extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->bread('文章', CPATH);
	}
	
	/**	
	 * 列表
	 */
	public function index()
	{
		$this->title('文章列表');
		$fields = array('id' => 'ID', 'title' => '标题', 'published' => '状态');
		$this->assign('fields', $fields);
		$this->assign('ajax_url', 'json');
	}
	
	/**
	 * json data for lists
	 */
	public function json()
	{
		$article = new MArticle();
		$article = $article->limit(parent::$input->post('iDisplayStart'), parent::$input->post('iDisplayLength'));
		if(parent::$input->post('sSearch')) {
			$article->where('title', 'like', '%'.parent::$input->post('sSearch').'%');
		}
		$lists = $article->find();
		$data = array(
			'sEcho' => parent::$input->post('sEcho'),
			'iTotalRecords' => 57,
			'iTotalDisplayRecords' => 57,
			'aaData' => $lists,
		);
		exit(json_encode($data));
	}
	
	/**
	 * edit
	 */
	public function edit($id = '')
	{
		if(parent::$input->isPost())	
		{
			$article = new MArticle();	
			$article->id = 5;
			$article->cate_id = 'test';
			$article->identifier = 'test2';
			$article->published = md5('123456');
			$article->title = 4;
			$article->keyword = 4;
			$article->body = 4;
			$article->created = time();
			$article->modified = time();
			$article->save();
			$this->jump(CPATH);
		} else if($id) {
			$article = new MArticle();
			$lists = $article->find($id);
			$this->assign('article', $lists);
		}
	}
	
}

// End;