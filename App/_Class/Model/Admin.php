<?php

namespace Model;

use Yeap\Model;

Class Admin extends Model{
	
	protected $table = 'admin';
	public static $cascade_delete = TRUE;

	public static $has = array(
		'car' => '\Model\Car',
		'memberships' => '\Model\Membership'
	);

	public static $belongs_to = array(
		'dorm' => '\Model\Dorm',
	);

	public static $has_many_through = array(
		'clubs' => array(
			'student_id' => '\Model\Membership',
			'club_id' => '\Model\Club'
		),
	);
}

// End;
