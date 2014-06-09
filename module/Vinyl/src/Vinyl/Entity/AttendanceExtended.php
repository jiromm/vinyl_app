<?php

namespace Vinyl\Entity;

use Vinyl\Helper\CommonHelper;
use Vinyl\Library\EntityBase;

class AttendanceExtended extends EntityBase {
	protected $id;
	protected $child_participation_status;
	protected $attendance_id;
	protected $attendance_therapy_id;
	protected $attendance_date_from;
	protected $attendance_date_to;
	protected $attendance_description;
	protected $attendance_timestamp;
	protected $child_id;
	protected $child_name;
	protected $parent_single_mother;
	protected $parent_in_need;

	public function getAttendanceDateFrom() {
		return CommonHelper::reformatDate($this->attendance_date_from);
	}

	public function setAttendanceDateFrom($value) {
		$this->attendance_date_from = $value;
	}

	public function getAttendanceDateTo() {
		return CommonHelper::reformatDate($this->attendance_date_to);
	}

	public function setAttendanceDateTo($value) {
		$this->attendance_date_to = $value;
	}

	public function getAttendanceDescription() {
		return $this->attendance_description;
	}

	public function setAttendanceDescription($value) {
		$this->attendance_description = $value;
	}

	public function getAttendanceId() {
		return $this->attendance_id;
	}

	public function setAttendanceId($value) {
		$this->attendance_id = $value;
	}

	public function getAttendanceTherapyId() {
		return $this->attendance_therapy_id;
	}

	public function setAttendanceTherapyId($value) {
		$this->attendance_therapy_id = $value;
	}

	public function getAttendanceTimestamp() {
		return $this->attendance_timestamp;
	}

	public function setAttendanceTimestamp($value) {
		$this->attendance_timestamp = $value;
	}

	public function getChildId() {
		return $this->child_id;
	}

	public function setChildId($value) {
		$this->child_id = $value;
	}

	public function getChildName() {
		return $this->child_name;
	}

	public function setChildName($value) {
		$this->child_name = $value;
	}

	public function getChildParticipationStatus() {
		return $this->child_participation_status;
	}

	public function setChildParticipationStatus($value) {
		$this->child_participation_status = $value;
	}

	public function getParentInNeed() {
		return $this->parent_in_need;
	}

	public function setParentInNeed($value) {
		$this->parent_in_need = $value;
	}

	public function getParentSingleMother() {
		return $this->parent_single_mother;
	}

	public function setParentSingleMother($value) {
		$this->parent_single_mother = $value;
	}

	public function getParticipationId() {
		return $this->id;
	}

	public function setParticipationId($value) {
		$this->id = $value;
	}
}
