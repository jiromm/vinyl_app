<?php

namespace Haymayrer\Mapper;

use Haymayrer\Library\CommonTableGateway;
use Haymayrer\Constant\DBTable;
use Zend\Db\Sql\Select;
use Zend\Http\Request;

class Parents extends CommonTableGateway {
	protected $tableName = DBTable::PARENT;
}
