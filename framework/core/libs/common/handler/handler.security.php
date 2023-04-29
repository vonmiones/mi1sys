<?php 
namespace framework\core\libs\common\handler;
/**
 * 
 */
class SystemSecurity
{
	
	function __construct()
	{
		self::getSecurityLibraries();
	}
	function SecurityLibraries($path,$flags = 0) {
	    $files = glob($path, $flags); 
	    foreach (glob(dirname($path).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
	        $files = array_merge($files, self::SecurityLibraries($dir.'/*'.basename($path), $flags));
	    }
	    return $files;
	}
	function getSecurityLibraries() {
		foreach (self::SecurityLibraries("framework/core/libs/security/*.php") as $key) {
			require_once $key;
		}
	}

}
?>