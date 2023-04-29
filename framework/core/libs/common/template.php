<?php

namespace framework\core\libs\common;
/**
 * 
 */
class Template
{
	
	function __construct($template=null)
	{
		if (!isset($template)) {
			if (empty($template)) {
				try {
				    require 'themes/default/init.php';
				} catch (Exception $e) {
				    echo $e->getMessage(), "\n";
				}		
			}
		}else{
			if (!empty($template)) {
				try {
				    require 'themes/'.$template.'/init.php';
				} catch (Exception $e) {
				    echo $e->getMessage(), "\n";
				}		
			}
		}
	}
}
?>