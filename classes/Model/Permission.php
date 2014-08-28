<?php

namespace Model;

use Dao\Auth;
use Dao\Role;
use Dao\RoleAuth;
use Dao\Admin;

class Permission {

	private $role;
	private $auth;
	private $user;

	public function __contract()
	{

	}

	/**
	 * add permission
	 */
	public function addPerm($path, $desc = '')
	{
		return $this->Permissions->add($path, $desc);
	}

	/**
	 * add role
	 * @param string $role name
	 * @param string $desc
	 * @return int $role_id
	 */
	public function addRole($role, $desc)
	{
		return $this->Roles->add($role, $desc);
	}

	public function bindPerm()
	{
		$this->assign($role_id, $perm_id);
	}

	public function bindRole()
	{
		$this->Users->assign($role_id, $user_id);
	}
}
