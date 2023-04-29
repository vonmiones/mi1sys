<?php
use framework\core\libs\common\handler as Handler;
use framework\core\libs\database as Database;

/**
 * 
 * Module Name: System Accont Login
 * Date Created: December 05, 2021 08:58 PM
 * Author: Von Microbert T. Miones
 * 
 */
class ApplicationModel
{
	

	function __construct()
	{
		self::init();
	}

	function init()
	{
		R::addDatabase('INSTALLEDAPPS','mysql:host='.SYSTEMDBHOST.';dbname='.SYSTEMDBNAME.'_apps',SYSTEMDBUSER, SYSTEMDBPASS );
		R::selectDatabase('INSTALLEDAPPS');
		// self::CreateEntityCache(self::GetEntities());
		// R::selectDatabase('ENTITY');
		R::close();
	}

	function GetInstalledApps()
	{
		R::selectDatabase('INSTALLEDAPPS');
		return R::getAll( 'SELECT * FROM apps' );
	}

	function GetInstalledApp($code="")
	{
		R::selectDatabase('INSTALLEDAPPS');
		return R::getAll( "SELECT * FROM apps WHERE appcode = '$code'"  );
	}

}
