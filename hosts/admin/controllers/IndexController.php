<?php

Class IndexController extends BaseController
{
	public function __construct()
	{
		parent::__construct('Article');
		//$this->bread('首页', CPATH);
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

}

// End;