<?php

namespace Vinyl\Entity;

use Vinyl\Helper\CommonHelper;
use Vinyl\Library\EntityBase;

class Attendance extends EntityBase {
	protected $id;
	protected $therapy_id;
	protected $date_from;
	protected $date_to;
	protected $description;
	protected $status;
	protected $timestamp;

	public function getId() {
		return $this->id;
	}

	public function setId($value) {
		$this->id = $value;
	}

	public function getTherapyId() {
		return $this->therapy_id;
	}

	public function setTherapyId($value) {
		$this->therapy_id = $value;
	}

	public function getDateFrom() {
		return CommonHelper::reformatDate($this->date_from);
	}

	public function setDateFrom($value) {
		$this->date_from = $value;
	}

	public function getDateTo() {
		return CommonHelper::reformatDate($this->date_to);
	}

	public function setDateTo($value) {
		$this->date_to = $value;
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
