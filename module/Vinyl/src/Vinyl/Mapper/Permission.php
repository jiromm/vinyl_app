<?php

namespace Vinyl\Mapper;

use Vinyl\Entity\AttendanceExtended;
use Vinyl\Library\CommonTableGateway;
use Vinyl\Constant\DBTable;
use Zend\Db\Sql\Select;

class Permission extends CommonTableGateway {
	protected $tableName = DBTable::PERMISSION;

	public function hasPermission($username, $permission) {
		$select = new Select($this->getTable());
		$select->join(
			['rel' => DBTable::REL_USER_PERMISSION],
			'rel.permission_id = ' . $this->getTable() . '.id',
			[],
			Select::JOIN_RIGHT
		);
		$select->join(
			['users' => DBTable::USER],
			'users.id = rel.user_id',
			[],
			Select::JOIN_LEFT
		);
		$select->where([
			'users.username' => $username,
			$this->getTable() . '.permission' => $permission
		]);

		return $this->hydrate(
			$this->selectWith($select),
			true
		);
	}
}
