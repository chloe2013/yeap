<?php
namespace Model;

use Yeap\Model;
use Yeap\Exception\YeapException;
use Yeap\Security;
use Yeap\Cookie;

Class Admin extends Model{
		
	const LOGIN_COOKIE = 'XADMIN';
	protected $table = 'admin';
	
	/**
	 * 后台登陆
	 * @param string $uid
	 * @param string $pwd
	 * @return bool
	 */
	public function login($uid, $pwd)
	{
		$user = $this->where('uid', $uid)->limit(1)->find();
		if(!$user)
		{
			throw new YeapException('用户不存在');
		}
		if(!$pwd || $user[0]->password != Security::password($pwd))
		{
			throw new YeapException('密码错误');
		}
		
		// 记录状态 set cookie
		$data = array(
			'uid' => $uid, 
		);
		return Cookie::set(self::LOGIN_COOKIE, $data);
	}
	
	/**
	 * 是否登录
	 * @return array $data
	 */
	public function isLogin()
	{
		$data = Cookie::get(self::LOGIN_COOKIE);
		if(isset($data['uid'])) {
			return $data;
		}
		return FALSE;
	}
	
	/**
	 * 退出登陆
	 */
	public function logout()
	{
		return Cookie::set(self::LOGIN_COOKIE, array(), array('expried' => -1));
	}
}

// End;
