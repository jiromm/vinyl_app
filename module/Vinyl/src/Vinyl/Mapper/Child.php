<?php

namespace Vinyl\Mapper;

use Vinyl\Entity\ChildExtended;
use Vinyl\Library\CommonTableGateway;
use Vinyl\Constant\DBTable;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Debug\Debug;

class Child extends CommonTableGateway {
	protected $tableName = DBTable::CHILD;

	/**
	 * @param Where|\Closure|array|null $where
	 * @return Child|null
	 */
	public function fetchAllWithParent($where = null) {
		$select = new Select($this->getTable());
		$select->join(
			'parent',
			'parent.id = ' . $this->getTable() . '.parent_id',
			['parent_name' => 'name'],
			Select::JOIN_LEFT
		);
		$select->where($where);

		return $this->hydrate(
			$this->selectWith($select)
		);
	}

	/**
	 * @param Where|\Closure|array|null $where
	 * @return Child|null
	 */
	public function fetchOneWithParent($where = null) {
		$select = new Select($this->getTable());
		$select->join(
			'parent',
			'parent.id = ' . $this->getTable() . '.parent_id',
			['parent_name' => 'name'],
			Select::JOIN_LEFT
		);
		$select->where($where);

		return $this->hydrate(
			$this->selectWith($select),
			true
		);
	}

	/**
	 * @return ChildExtended[]|\ArrayObject|null
	 */
	public function fetchExtendedChildList() {
		$this->setEntity(new ChildExtended());

		$select = new Select($this->getTable());
		$select->columns(['id', 'name', 'disease']);
		$select->join(
			'participation',
			'participation.child_id = child.id',
			['attendance_count' => new Expression('COUNT(participation.attendance_id)')],
			Select::JOIN_LEFT
		);
		$select->join(
			'parent',
			'parent.id = child.parent_id',
			['single_mother', 'in_need'],
			Select::JOIN_LEFT
		);
		$select->join(
			'attendance',
			'attendance.id = participation.attendance_id',
			[],
			Select::JOIN_LEFT
		);
		$select->group('child.id');
		$select->order(['attendance_count ASC', 'single_mother DESC', 'in_need DESC']);

		return $this->hydrate(
			$this->selectWith($select)
		);
	}

	/**
	 * @param array $exceptions
	 * @return ChildExtended[]|\ArrayObject|null
	 */
	public function fetchExtendedChildListWithExceptions(array $exceptions) {
		$this->setEntity(new ChildExtended());
		$exceptionsString = implode(',', $exceptions);

		$select = new Select($this->getTable());
		$select->columns(['id', 'name', 'disease']);
		$select->join(
			'participation',
			'participation.child_id = child.id',
			['attendance_count' => new Expression('COUNT(participation.attendance_id)')],
			Select::JOIN_LEFT
		);
		$select->join(
			'parent',
			'parent.id = child.parent_id',
			['single_mother', 'in_need'],
			Select::JOIN_LEFT
		);
		$select->where->expression("
			child.id not in ({$exceptionsString})
		", null);
		$select->group('child.id');
		$select->order(['attendance_count ASC', 'single_mother DESC', 'in_need DESC']);

		return $this->hydrate(
			$this->selectWith($select)
		);
	}
}
