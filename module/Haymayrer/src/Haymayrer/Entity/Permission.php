<?php

namespace Haymayrer\Entity;

use Haymayrer\Library\EntityBase;

class Permission extends EntityBase {
	protected $id;
	protected $permission;
	protected $description;

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setPermission($permission) {
		$this->permission = $permission;
	}

	public function getPermission() {
		return $this->permission;
	}

	public function setDescription($description) {
		$this->description = $description;
	}

	public function getDescription() {
		return $this->description;
	}
}
