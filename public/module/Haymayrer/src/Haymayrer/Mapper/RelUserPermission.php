<?php

namespace Haymayrer\Mapper;

use Haymayrer\Entity\AttendanceExtended;
use Haymayrer\Library\CommonTableGateway;
use Haymayrer\Constant\DBTable;
use Zend\Db\Sql\Select;

class RelUserPermission extends CommonTableGateway {
	protected $tableName = DBTable::REL_USER_PERMISSION;
}
