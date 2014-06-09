<?php

namespace Haymayrer\Entity;

use Haymayrer\Helper\CommonHelper;
use Haymayrer\Library\EntityBase;

class Child extends EntityBase {
	protected $id;
	protected $parent_id;
	protected $parent_name;
	protected $name;
	protected $disease;
	protected $birthday;
	protected $description;
	protected $timestamp;

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getParentId() {
		return $this->parent_id;
	}

	public function setParentId($value) {
		$this->parent_id = $value;
	}

	public function getParentName() {
		return $this->parent_name;
	}

	public function setParentName($value) {
		$this->parent_name = $value;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($value) {
		$this->name = $value;
	}

	public function getDisease() {
		return $this->disease;
	}

	public function setDisease($value) {
		$this->disease = $value;
	}

	public function getBirthday() {
		return CommonHelper::reformatDate($this->birthday);
	}

	public function setBirthday($value) {
		$this->birthday = $value;
	}

	public function getDescription() {
		return $this->description;
	}

	public function setDescription($value) {
		$this->description = $value;
	}

	public function getTimestamp() {
		return $this->timestamp;
	}

	public function setTimestamp($value) {
		$this->timestamp = $value;
	}
}
