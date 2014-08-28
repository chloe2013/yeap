<?php

Class ProductController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Product');
		$this->bread('产品', CPATH);
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
			'market_price' => array('n' => '市场价'),
			'step_price' => array('n' => '定金'),
			'price' => array('n' => '价格'),
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
			array('name' => 'market_price', 'title' => '市场价', 'type' => 'input', 'tip' => '2位小数'),
			array('name' => 'step_price', 'title' => '定金', 'type' => 'input', 'tip' => '2位小数'),
			array('name' => 'price', 'title' => '价格', 'type' => 'input', 'tip' => '2位小数'),
			array('name' => 'aimg', 'title' => 'a图', 'type' => 'input', 'tip' => '直接填写地址'),
			array('name' => 'bimg', 'title' => 'b图', 'type' => 'input', 'tip' => '直接填写地址'),
			array('name' => 'intro', 'title' => '简介', 'type' => 'textarea'),
			array('name' => 'notes', 'title' => '详细描述', 'type' => 'textarea'),
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
		$article->title = parent::$input->post('title');
		$article->market_price = parent::$input->post('market_price');
		$article->step_price = parent::$input->post('step_price');
		$article->price = parent::$input->post('price');
		$article->aimg = parent::$input->post('aimg');
		$article->bimg = parent::$input->post('bimg');
		$article->intro = parent::$input->post('intro');
		$article->notes = parent::$input->post('notes');
		$article->created = time();
		$article->modified = time();
		$article->save();
	}

}

// End;