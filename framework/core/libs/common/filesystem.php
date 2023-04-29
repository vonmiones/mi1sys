<?php 

namespace framework\core\libs\common;

/**
 * 
 */
class FileSystem
{
	
	function __construct()
	{
	}

	function getLibDir($path)
	{
		return array_filter(glob($path), 'is_dir');
	}
	function getLibClass($path,$flags = 0) {
	    $files = glob($path, $flags); 
	    foreach (glob(dirname($path).'/*.php', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
	        $files = array_merge($files, getLibClass($dir.'/*'.basename($path), $flags));
	    }
	    return $files;
	}
}
?>