<?php 

namespace framework\core\libs\database;
use framework\core\libs\common as Common;
/**
 * 
 */
class PropelORM
{
	
	function __construct()
	{
		$fs = new Common\Filesystem();
		$dependencies = [
			"Propel.php",
		];
		foreach ($fs->getLibClass("framework/vendor/propel/Runtime/*") as $key) {
			foreach ($dependencies as $order) {
				if (stripos($key, $order)) {
					// return $key;
					// echo "$order<br>";
					require_once $key;
				}
			}
		}
	}
}
?>