<?php
use framework\core\libs\common\handler as Handler;
use framework\core\libs\database as Database;

$v = new Handler\Vendor();
$orm = $v->getDBVendorFramework('framework/core/libs/database/*',"redbean");
require $orm;
$orm = new Database\RedBeanORM();