<?php

namespace Vinyl\Mapper;

use Vinyl\Library\CommonTableGateway;
use Vinyl\Constant\DBTable;

class User extends CommonTableGateway {
	protected $tableName = DBTable::USER;
}
