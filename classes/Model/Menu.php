<?php
namespace Model;

use Yeap\Exception\YeapException;
use Dao\Auth;

Class Menu {

	/**
	 *
	 */
	public function treeMenu()
	{
		$auth = new Auth();
		$d = $auth->where('is_show', 1)->find();
		return $this->create($this->menu(0, $d));
	}

	private function menu($pid, $d)
	{
		$r = array();
		foreach($d as $v)
		{
			if((int)$v->parent_id === (int)$pid)
			{
				$r[$v->id] = array(
					'url' => $v->url,
					'title' => $v->name,
					'icon' => $v->icon,
					'child' => $this->menu($v->id, $d)
				);
			}
		}
		return $r;
	}

	/**
	 *
	 */
	public function create($d)
	{
		$html = '';
		foreach($d as $v)
		{
		    $arrow = $v['child'] ? '<b class="arrow icon-angle-down"></b>' : '';
			$url = $v['child'] ? '"#" class="dropdown-toggle"' : $v['url'];
		    $html .= "<li>
						<a href={$url}>
							<i class='{.icon}'></i>
							<span class='menu-text'> {$v['title']} </span>
							{$arrow}
						</a>";
			if($v['child'])
			{
				$html .= '<ul class="submenu">';
				$html .= $this->create($v['child']);
				$html .= '</ul>';
			}
			$html .= '</li>';
		}
		return $html;
	}

}

// End;
