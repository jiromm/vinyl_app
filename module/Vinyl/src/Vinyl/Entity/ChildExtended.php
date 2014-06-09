<?php

namespace Vinyl\Entity;

use Vinyl\Library\EntityBase;

class ChildExtended extends EntityBase {
	protected $id;
	protected $name;
	protected $disease;
	protected $single_mother;
	protected $in_need;
	protected $attendance_count;

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getName() {
		return $this->name;
	}

	public function getDisease() {
		return $this->disease;
	}

	public function getSingleMother() {
		return $this->single_mother;
	}

	public function getInNeed() {
		return $this->in_need;
	}

	public function getAttendanceCount() {
		return $this->attendance_count;
	}
}
