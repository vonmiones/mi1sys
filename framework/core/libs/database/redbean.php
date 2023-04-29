<?php 

namespace framework\core\libs\database;
use framework\core\libs\common as Common;
/**
 * 
 */
class RedBeanORM
{
	
	function __construct()
	{
		$fs = new Common\Filesystem();
		$dependencies = [
			"redbean.php",
		];
		foreach ($fs->getLibClass("framework/vendor/redbean/*") as $key) {
			foreach ($dependencies as $order) {
				if (stripos($key, $order)) {
					require_once $key;
				}
			}
		}
	}
}
?>