<?php 

namespace framework\core\libs\qrcode;
use framework\core\libs\common as Common;
/**
 * 
 */
class PhpQRCodeLibs
{
	
	function __construct()
	{
		$fs = new Common\Filesystem();
		$dependencies = [

			"qrconst.php",
			"qrconfig.php",
			"qrtools.php",
			"qrspec.php",
			"qrimage.php",
			"qrinput.php",
			"qrbitstream.php",
			"qrsplit.php",
			"qrrscode.php",
			"qrmask.php",
			"qrencode.php"

		];
		foreach ($fs->getLibClass("framework/vendor/phpqrcode/*") as $key) {
			foreach ($dependencies as $order) {
				if (stripos($key, $order)) {

					echo $key . "<br>";
					require_once $key;
				}
			}
		}
	}
}
?>



