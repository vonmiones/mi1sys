<?php 

namespace framework\core\libs\database;
use framework\core\libs\common as Common;

/**
 * 
 */
class FuzzyMatch
{
	
	function __construct()
	{
		$fs = new Common\Filesystem();
		$dependencies = [
			"Collection.php",
			"Fuzz.php",
			"Process.php",
			"Utils.php",
			"StringProcessor.php",
			"Diff/SequenceMatcher.php",
			"Diff/Diff_SequenceMatcher.php"
		];
		foreach ($fs->getLibClass("framework/vendor/FuzzyWuzzy/*") as $key) {
			foreach ($dependencies as $order) {
				if (stripos($key, $order)) {
					// return $key;
					require_once $key;
				}
			}
		}
	}
}
?>