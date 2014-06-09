<?php

namespace Haymayrer\Mapper;

use Haymayrer\Library\CommonTableGateway;
use Haymayrer\Constant\DBTable;

class User extends CommonTableGateway {
	protected $tableName = DBTable::USER;
}
