<?php
namespace Model;

use Yeap\Model;
use Yeap\Exception\YeapException;
use Yeap\Security;
use Yeap\Cookie;

Class Admin extends Model{
	
	protected $table = 'admin';
	
	/**
	 * 后台登陆
	 * @param string $uid
	 * @param string $pwd
	 */
	public function login($uid, $pwd)
	{
		$user = $this->where('uid', $uid)->limit(1)->find();
		if(!$user)
		{
			throw new YeapException('用户不存在');
		}
		if(!$pwd || $user->password != Security::password($pwd))
		{
			throw new YeapException('密码错误');
		}
		
		// 记录状态 set cookie
		Cookie::set('ye_admin');
	}
	
	/**
	 * 
	 */
	public function isLogin()
	{
		$data = Cookie::get('ye_admin');
	}
}

// End;
