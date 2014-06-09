<?php

namespace Vinyl\Entity;

use Vinyl\Library\EntityBase;

class User extends EntityBase {
	protected $id;
	protected $username;
	protected $password;
	protected $active;

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getUsername() {
		return $this->username;
	}

	public function setUsername($value) {
		$this->username = $value;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($value) {
		$this->password = md5($value);
	}

	public function setActive($active) {
		$this->active = $active;
	}

	public function getActive() {
		return $this->active;
	}
}
