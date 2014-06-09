<?php

namespace Vinyl\Mapper;

use Vinyl\Entity\AttendanceExtended;
use Vinyl\Library\CommonTableGateway;
use Vinyl\Constant\DBTable;
use Zend\Db\Sql\Select;
use Zend\Debug\Debug;

class Participation extends CommonTableGateway {
	protected $tableName = DBTable::PARTICIPATION;

	/**
	 * @param int $attendanceId
	 * @return AttendanceExtended[]|\ArrayObject|null
	 */
	public function fetchExtendedAttendanceList($attendanceId) {
		$this->setEntity(new AttendanceExtended());

		$select = new Select($this->getTable());
		$select->columns([
			'id',
			'participation_id' => 'id',
			'child_participation_status' => 'status',
		]);
		$select->join(
			DBTable::ATTENDANCE,
			DBTable::ATTENDANCE . '.id = ' . DBTable::PARTICIPATION . '.attendance_id',
			[
				'attendance_id' => 'id',
				'attendance_therapy_id' => 'therapy_id',
				'attendance_date_from' => 'date_from',
				'attendance_date_to' => 'date_to',
				'attendance_description' => 'description',
				'attendance_timestamp' => 'timestamp',
			],
			Select::JOIN_LEFT
		);
		$select->join(
			DBTable::CHILD,
			DBTable::CHILD . '.id = ' . DBTable::PARTICIPATION . '.child_id',
			[
				'child_id' => 'id',
				'child_name' => 'name',
			],
			Select::JOIN_LEFT
		);
		$select->join(
			DBTable::PARENT,
			DBTable::PARENT . '.id = ' . DBTable::CHILD . '.parent_id',
			[
				'parent_single_mother' => 'single_mother',
				'parent_in_need' => 'in_need',
			],
			Select::JOIN_LEFT
		);
		$select->where([
			DBTable::ATTENDANCE . '.id = ' . $attendanceId
		]);

		return $this->hydrate(
			$this->selectWith($select)
		);
	}
}
