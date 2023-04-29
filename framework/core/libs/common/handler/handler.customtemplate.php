<?php 

namespace framework\core\libs\common\handler;
/**
 * 
 */
class CustomTemplate
{
	
	function __construct()
	{

	}

	function CustomTemplateStyles($template,$path,$flags = 0) {
		return self::getLibUI("themes/".$template.$path);
	}

}
?>