<?php

namespace Vinyl\Mapper;

use Vinyl\Constant\DBData;
use Vinyl\Library\CommonTableGateway;
use Vinyl\Constant\DBTable;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class Fence extends CommonTableGateway {
	protected $tableName = DBTable::FENCE;

	/**
	 * @param Where|\Closure|array|null $where
	 * @return \Vinyl\Entity\Fence[]|\ArrayObject
	 */
	public function fetchAllWithCategory($where = null) {
		$select = new Select($this->getTable());
		$select->join(
			['cat' => DBTable::CATEGORY],
			'cat.id = ' . $this->getTable() . '.category_id',
			['category' => 'name'],
			Select::JOIN_LEFT
		);
		$select->where($where);
		$select->order([$this->getTable() . '.category_id ASC']);

		return $this->hydrate(
			$this->selectWith($select)
		);
	}
}
