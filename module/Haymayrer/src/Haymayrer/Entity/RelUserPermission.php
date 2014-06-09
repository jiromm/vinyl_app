<?php

namespace Haymayrer\Entity;

use Haymayrer\Library\EntityBase;

class RelUserPermission extends EntityBase {
	protected $id;
	protected $permission_id;
	protected $user_id;

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setUserId($user_id) {
		$this->user_id = $user_id;
	}

	public function getUserId() {
		return $this->user_id;
	}

	public function setPermissionId($permission_id) {
		$this->permission_id = $permission_id;
	}

	public function getPermissionId() {
		return $this->permission_id;
	}
}
