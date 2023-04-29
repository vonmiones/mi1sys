<?php 

namespace framework\core\libs\common\handler;
/**
 * Coded by Von Miones
 */
class UI
{
	
	function __construct()
	{
		
	}

	function getLibs($path,$flags = 0) {
	    $files = glob($path, $flags); 
	    foreach (glob(dirname($path).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
	        $files = array_merge($files, getLibs($dir.'/*'.basename($path), $flags));
	    }
	    return $files;
	}

	function getLibUI($path,$flags = 0) {
	    $files = glob($path, $flags); 
	    foreach (glob(dirname($path).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
	        $files = array_merge($files, getLibUI($dir.'/*'.basename($path), $flags));
	    }
	    return $files;
	}

	// Initialize UI Elements
	function initStyle($a,$b){
		if (isset($b) !="") {
		foreach ($a as $sk => $sv) {
				$strArray = explode('/',$sv);
				$lastElement = end($strArray);
				if (strpos($b, $lastElement) === 0) {
					header("Content-type: text/css", true);
					include $sv;
				}
			}		
		}

	}
	// Initialize UI Elements
	function initStyleMap($a,$b){
		if (isset($b) !="") {
		foreach ($a as $sk => $sv) {
				$strArray = explode('/',$sv);
				$lastElement = end($strArray);
				if (strpos($b, $lastElement) === 0) {
					header("Content-type: text/css", true);
					include $sv.".map";
				}
			}		
		}

	}
	// Initialize UI Elements
	function initScripts($a,$b){
		if (isset($b)!="") {
			foreach ($a as $sk => $sv) {
				$strArray = explode('/',$sv);
				$lastElement = end($strArray);
				if (strpos($b, $lastElement) === 0) {
					header("Content-type: application/javascript ", true);
					include $sv;
				}
			}		
		}
	}	// Initialize UI Elements
	function initScriptsMap($a,$b){
		if (isset($b)!="") {
			foreach ($a as $sk => $sv) {
				$strArray = explode('/',$sv);
				$lastElement = end($strArray);
				if (strpos($b, $lastElement) === 0) {
					header("Content-type: application/javascript ", true);
					include $sv.".map";
				}
			}		
		}
	}
}
?>