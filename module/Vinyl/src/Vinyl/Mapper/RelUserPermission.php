<?php

namespace Vinyl\Mapper;

use Vinyl\Entity\AttendanceExtended;
use Vinyl\Library\CommonTableGateway;
use Vinyl\Constant\DBTable;
use Zend\Db\Sql\Select;

class RelUserPermission extends CommonTableGateway {
	protected $tableName = DBTable::REL_USER_PERMISSION;
}
