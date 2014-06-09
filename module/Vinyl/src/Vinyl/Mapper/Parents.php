<?php

namespace Vinyl\Mapper;

use Vinyl\Library\CommonTableGateway;
use Vinyl\Constant\DBTable;
use Zend\Db\Sql\Select;
use Zend\Http\Request;

class Parents extends CommonTableGateway {
	protected $tableName = DBTable::PARENT;
}
