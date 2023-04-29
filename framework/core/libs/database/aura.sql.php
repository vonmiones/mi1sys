<?php 

namespace framework\core\libs\database;
use framework\core\libs\common as Common;

/**
 * 
 */
class AuraSQL
{
	
	function __construct()
	{
		$fs = new Common\Filesystem();
		$dependencies = [
			"ConnectionLocatorInterface.php",
			"ConnectionLocator.php",
			"Exception.php",
			"ExceptionPdo.php",
			"ExtendedPdoInterface.php",
			"PdoInterface.php",
			"Profiler.php"
		];
		foreach ($fs->getLibClass("framework/vendor/aura.sql/*") as $key) {
			foreach ($dependencies as $order) {
				if (stripos($key, $order)) {
					// return $key;
					echo "$order<br>";
					require_once $key;
				}
			}
		}
	}
}
?>