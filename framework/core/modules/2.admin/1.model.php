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
class EntityModel
{
	

	function __construct()
	{
		self::init();
	}

	function init()
	{
		R::addDatabase('ENTITY','mysql:host='.SYSTEMDBHOST.';dbname='.SYSTEMDBNAME.'_entities',SYSTEMDBUSER, SYSTEMDBPASS );
		R::selectDatabase('ENTITY');
		// self::CreateEntityCache(self::GetEntities());
		// R::selectDatabase('ENTITY');
		R::close();
	}

	function GetEntities()
	{
		R::selectDatabase('ENTITY');
		// return R::getAll( 'SELECT * FROM entitymoph' );
		return R::getAll( 'SELECT * FROM entity' );
	}

	function GetEntityProfile($id)
	{
		R::selectDatabase('LOGIN');
		$xid = (int)trim($id);
		$objid=R::getRow( "SELECT * FROM accountlogin WHERE id = $xid" )["entity"];
		R::selectDatabase('ENTITY');
		// $profile = R::getRow("SELECT * FROM entitymoph WHERE objid = '$objid'");
		$profile = R::getRow("SELECT * FROM entity WHERE objid = '$objid'");
		return $profile;
	}
	function CreateEntityCache($entities)
	{
		// if (!file_exists("cache/entity.db")) {
		// 	$database = new SQLite3('cache/entity.db');
		// }else{
		// 	R::addDatabase('ENTITYCACHE', 'sqlite:cache/entity.db' );
		// 	R::selectDatabase('ENTITYCACHE');

		// 	$entity_table = R::dispense("entitymoph"); //no need for model

		// 	try {			
		// 		R::begin();
		// 		$index=0;
		// 		foreach ($entities as $entity) {
		// 			$entity_table["objid"] = $entity["objid"];
		// 			$entity_table["EMPID"] = $entity["EMPID"];
		// 			$entity_table["OFFICE"] = $entity["OFFICE"];
		// 			$entity_table["LASTNAME"] = $entity["LASTNAME"];
		// 			$entity_table["FIRSTNAME"] = $entity["FIRSTNAME"];
		// 			$entity_table["MIDDLENAME"] = $entity["MIDDLENAME"];
		// 			$entity_table["SUFFIX"] = $entity["SUFFIX"];
		// 			$entity_table["ID"] = $index;
		// 			$index++;
		// 			R::store( $entity_table );
		// 		}
		// 		R::commit();
		// 	} catch (Exception $e) {
		// 		R::rollback();
		// 	}

		// }
	}
}


class AccountsModel
{
	

	function __construct()
	{
		self::init();
	}

	function init()
	{
		R::addDatabase('ACCOUNTS','mysql:host='.SYSTEMDBHOST.';dbname='.SYSTEMDBNAME.'_accounts',SYSTEMDBUSER, SYSTEMDBPASS );
		R::selectDatabase('ACCOUNTS');
		// self::CreateEntityCache(self::GetEntities());
		// R::selectDatabase('ACCOUNTS');
		R::close();
	}

	function GetAccountSystems()
	{
		R::selectDatabase('ACCOUNTS');
		return R::getAll( 'SELECT * FROM accountsystems' );
	}

	function GetAccountSystemsProfile($id)
	{
		R::selectDatabase('ACCOUNTS');
		$objid = trim($id);
		R::selectDatabase('ACCOUNTS');
		$profile = R::getRow( "SELECT * FROM accountsystems WHERE entity ='$objid'");
		return $profile;
	}
}

class GeoInfoModel
{
	
	function __construct()
	{
		self::init();
	}

	function init()
	{
		R::addDatabase('GEOINFO','mysql:host='.SYSTEMDBHOST.';dbname='.SYSTEMDBNAME.'_geoinfo',SYSTEMDBUSER, SYSTEMDBPASS );
		R::close();
	}
	function GetRegions()
	{
		return R::getAll( 'SELECT NATIONAL_CODE, REG_ID, DESCRIPTION FROM region' );
	}
	function GetProvinces()
	{
		return R::getAll( 'SELECT NATIONAL_CODE, REG_ID, PROV_ID, DESCRIPTION FROM province' );
	}
	function GetCityMunicipalities()
	{
		return R::getAll( 'SELECT  NATIONAL_CODE, REG_ID, PROV_ID, CITYMUN_ID, DESCRIPTION FROM citymunicipality' );
	}
	function GetBarangays()
	{
		return R::getAll( 'SELECT NATIONAL_CODE, REG_ID, PROV_ID, CITYMUN_ID, BARANGAY_ID, DESCRIPTION FROM barangay ORDER BY BARANGAY_ID ASC' );
	}
}




/**
 * 
 */
class InstalledApplicationModel
{
	

	function __construct()
	{
		self::init();
	}

	function init()
	{
		R::addDatabase('APPS','mysql:host='.SYSTEMDBHOST.';dbname='.SYSTEMDBNAME.'_apps',SYSTEMDBUSER, SYSTEMDBPASS );
		R::selectDatabase('APPS');
		R::close();
	}

	function GetInstalledApplications()
	{
		R::selectDatabase('APPS');
		return R::getAll( 'SELECT * FROM apps' );
	}
}