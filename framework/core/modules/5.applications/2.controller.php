<?php
global $el;
global $conf;
global $appc;
use framework\core\libs\common\handler as Handler;
$appc = new ApplicationModel();


/**
 * 
 */
class ApplicationModule
{
	
	function __construct()
	{

	}

	function init()
	{
		global $el;
		foreach ($el->getLibClass("apps") as $key => $v) {
		    foreach ($el->getLibClass($v."/*") as $m) {
		    	if (is_dir($m)) { // MODIFIED ON JAN 21, 2022
			        include "$m/app.php"; 
		    	}
		    }
		}
	}
	
	function getAppInfo()
	{
		$comment = new Comment();
		return $comment->getFileComments();
	}
	
	function getAppName()
	{
		$name = array();
		$comment = new Comment();
		foreach ($comment->getFileComments() as $k) {
			array_push($name,preg_split('/:/',$k[0])[1]  );
		}
		return $name;
	}
	function getApp()
	{
		$name = array();
		$comment = new Comment();
		foreach ($comment->getFileComments() as $k) {
			array_push($name,preg_split('/:/',$k[1])[1]  );
		}
		return $name;
	}

	function GetInstalledApps()
	{
		global $appc;
		R::selectDatabase('INSTALLEDAPPS');
		return $appc->GetInstalledApps();
	}

	function GetInstalledApp($code)
	{
		global $appc;
		R::selectDatabase('INSTALLEDAPPS');
		return $appc->GetInstalledApp($code);
	}

}
?>