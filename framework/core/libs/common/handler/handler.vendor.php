<?php 
namespace framework\core\libs\common\handler;
/**
 * 
 */
class Vendor extends UI
{
	
	function __construct()
	{
	}

	function getVendorStyles($path,$flags = 0) {
		return self::getLibUI("vendors/".$path);
	}

	function getDBVendorFramework($path, $framework = 'common.mysql.php',$flags = 0) {

		foreach (self::getLibUI($path) as $key) {
			if (stripos($key, $framework)) {
				return $key;
			}
		}
	}

}
?>