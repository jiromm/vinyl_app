<?php

namespace Vinyl\Entity;

use Vinyl\Library\EntityBase;

class Participation extends EntityBase {
	protected $id;
	protected $child_id;
	protected $attendance_id;
	protected $status;

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getChildId() {
		return $this->child_id;
	}

	public function setChildId($value) {
		$this->child_id = $value;
	}

	public function getAttendanceId() {
		return $this->attendance_id;
	}

	public function setAttendanceId($value) {
		$this->attendance_id = $value;
	}

	public function getStatus() {
		return $this->status;
	}

	public function setStatus($value) {
		$this->status = $value;
	}
}
