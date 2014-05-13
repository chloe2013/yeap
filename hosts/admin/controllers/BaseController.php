<?php

use Yeap\Controller;
use Yeap\Request;
use Model\Auth;
use Model\Admin;

Class BaseController extends Controller
{
	protected $model = null;	
	public function __construct($m = null)
	{
		parent::__construct();
		
		// 连接数据库
		$this->loadDb();
		$this->model = $m;
		
		// 后台登录权限
		
		// 后台用户登录信息设置
		$this->checkLogin();
	}
	
	protected function model()
	{
		$m = $this->model;
		$this->model = new $m();
	}
	
	/**
	 * 登录检查
	 */
	private function checkLogin()
	{
		$admin = new Admin();
		if($login = $admin->isLogin()) {
			$this->assign('login', $login);
		} else if(strpos(Request::getUrl(), '/login') === FALSE) {
			$this->jump('/login');
		}
	}
	
	/**
	 * controller 之前做的事
	 */
	public function before()
	{
		parent::before();
		
		// 后台菜单设置
		$this->menu();
	}
	
	/**
	 * 菜单设置
	 */
	private function menu()
	{
		if($this->out_type != 'view'){return;}
		$menu = array(
			array('title' => 'Article', 'url' => '/article', 'icon' => 'icon-align-justify'),
			array('title' => 'Categroy', 'url' => '/categroy', 'icon' => 'icon-globe'),
			array('title' => 'Banner', 'url' => '/banner', 'icon' => 'icon-picture'),
		);
		$this->assign('mmenu', $menu);
	}
	
	/**
	 * 首页
	 */
	public function index()
	{
		$this->title('列表');
		$fields = $this->listsFields();
		$aoColumns = array(array('mDataProp' => 'id', 'sClass' => 'center'));
		foreach($fields as $k => $v)
		{
			$aoColumns[] = array('mDataProp' => $k, 'sClass' => 'center');
		}
		$this->assign('fields', $fields);
		$this->assign('lists_fields', $aoColumns);
		$this->assign('ajax_url', 'json');
	}
	
	/**
	 * 列表页 for datatables
	 */
	public function json()
	{
		$this->model();
		
		$start = (int)parent::$input->post('iDisplayStart');
		$len = (int)parent::$input->post('iDisplayLength');
		$page = ceil($start/$len);
		
		$this->model = $this->model->limit($start, $len);
		$this->listSearch();
		$this->model->field(array_keys(self::listsFields()));
		$lists = $this->model->find();
		$total = $this->model->count();
		$data = array(
			'sEcho' => parent::$input->post('sEcho'),
			'iTotalRecords' => $total,
			'iTotalDisplayRecords' => count($lists),
			'aaData' => $lists,
		);
		exit(json_encode($data));
	}
	
	/**
	 * 编辑页
	 */
	public function edit($id = '')
	{
		$this->title('新增');
		
		if(parent::$input->isPost())	
		{
			$this->editProc();
			$this->jump(CPATH);
		} else if($id) {
			$this->title('编辑');
			$this->model();	
			$lists = $this->model->find($id);
			$this->assign('data', $lists);
		}
		$this->assign('fields', $this->editFields());
		$this->layout('form');
	}
	
	/**
	 * 编辑提交处理
	 */
	protected function editProc(){}
	
	/**
	 * 列表过滤
	 */
	protected function listSearch(){}
	
	/**
	 * 列表字段
	 */
	protected static function listsFields()
	{
		return array();
	}
	
	/**
	 * 编辑字段
	 * array(n=>name, w=>width, f=>field, c=>class, s=>search)
	 */
	protected static function editFields()
	{
		return array();
	}
	
}

// End;