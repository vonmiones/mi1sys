<?php
use framework\core\libs\common\handler as Handler;

/**
 * 
 * Module Name: System Accont Login
 * Date Created: December 05, 2021 08:58 PM
 * Author: Von Microbert T. Miones
 * 
 */
global $Entities;
global $Accounts;
global $GeoInfo;
global $SystemSecurity;
global $isLoginSuccess;
global $e;
$Entities = new EntityModel();
$Accounts = new AccountsModel();
$GeoInfo = new GeoInfoModel();
$InstalledApps = new InstalledApplicationModel();

$SystemSecurity = new Handler\SystemSecurity();
$e = new NameTokenizer();
$filter = new AntiXSS();
$isLoginSuccess = null;


function GetAccountSystems()
{
	global $Accounts;
    R::selectDatabase('ACCOUNTS');
	return $Accounts->GetAccountSystems();
}

function GetInstalledApplications()
{
    global $Accounts;
    R::selectDatabase('INSTALLEDAPPS');
    return $Accounts->InstalledApps();
}

function GetAccountSystemsProfile($id)
{
    global $Accounts;
    R::selectDatabase('ACCOUNTS');
    return $Accounts->GetAccountSystemsProfile(trim($id));
}

function GetEntities()
{
    global $Entities;
    R::selectDatabase('ENTITY');
    return $Entities->GetEntities();
}

function GetEntityProfile($id)
{
    global $Entities;
    R::selectDatabase('ENTITY');
    return $Entities->GetEntityProfile(trim($id));
}

function GetRegions()
{
    global $GeoInfo;
    R::selectDatabase('GEOINFO');
    return $GeoInfo->GetRegions();
}
function GetProvinces()
{
    global $GeoInfo;
    R::selectDatabase('GEOINFO');
    return $GeoInfo->GetProvinces();
}
function GetCityMunicipalities()
{
    global $GeoInfo;
    R::selectDatabase('GEOINFO');
    return $GeoInfo->GetCityMunicipalities();
}
function GetBarangays()
{
    global $GeoInfo;
    R::selectDatabase('GEOINFO');
    return $GeoInfo->GetBarangays();
}


function saveAccount($data)
{
    global $e;
    R::close();
    R::selectDatabase('LOGIN');
    $table = R::dispense('accountlogin');
    $table->objid = "ACCOUNT:".md5(uniqid("ACCOUNT:",true));
    $table->entity = $data["object"];
    $table->user = $e->FormName($data["user"]);
    $table->pass = $e->FormName($data["pass"]);
    $table->email = $e->FormName($data["email"]);
    $table->role = $e->FormName($data["role"]);
    $table->status = "PENDING";
    $table->dtcreated = date("m/d/Y h:i:s a");
    $table->dtupdated = date("m/d/Y h:i:s a");
    $table->dtsuspended = null;
    $table->dtreactivated = null;
    $id = R::store( $table );
    return R::load( 'accountlogin', $id);

}
function saveRole($data)
{
    global $e;
    R::close();
    R::selectDatabase('LOGIN');
    $table = R::dispense('accountsystems');
    $table->objid = "INSTALLEDAPPS:".md5(uniqid("INSTALLEDAPPS:",true));
    $table->entity = $data["object"];
    $table->role = $e->FormName($data["role"]);
    $table->appids = $e->FormName($data["appids"]);
    $table->appnames = $e->FormName($data["appnames"]);
    $id = R::store( $table );
    return R::load( 'accountsystems', $id);

}

function checkExistingAccount($data)
{
    global $e;
    R::close();
    R::selectDatabase('LOGIN');
    $objid = trim($data["object"]);
    $id = R::findAll('accountlogin','entity=?',[$objid]);
    // // return R::load( 'accountlogin', $id);
    return $id;
}

function deleteAccount($data)
{
    global $e;
    R::close();
    R::selectDatabase('LOGIN');
    $objid = trim($data["object"]);
    $id = R::findOne('accountlogin','entity=?',[$objid])['id'];
    $table = R::load( 'accountlogin',$id);

    if (count($table) > 1) {
        $table->status = "DELETED";
        $id = R::store( $table );
    }
    return R::load( 'accountlogin', $id);

}
function disableAccount($data)
{
    global $e;
    R::close();
    R::selectDatabase('LOGIN');
    $id = trim($data["id"]);
    $table = R::load( 'accountlogin',$id);
    $table->status = "DISABLED";
    $id = R::store( $table );
    return R::load( 'accountlogin', $id);
}
function updateAccount($data)
{
    global $e;
    R::close();
    R::selectDatabase('LOGIN');
    $objid = trim($data["object"]);
    $id = R::findOne('accountlogin','entity=?',[$objid])['id'];
    $table = R::load( 'accountlogin',$id);
    $table->entity = $e->FormName($data["entity"]);
    $table->user = $e->FormName($data["user"]);
    $table->pass = $e->FormName($data["pass"]);
    $table->email = $e->FormName($data["email"]);

    $id = R::store( $table );
    return R::load( 'accountlogin', $id);
}
function updateRole($data)
{
    global $e;
    R::close();
    R::selectDatabase('LOGIN');
    $objid = trim($data["object"]);
    $id = R::findOne('accountsystems','entity=?',[$objid])['id'];
    $table = R::load( 'accountsystems',$id);
    $table->role = $e->FormName($data["role"]);
    $table->appids = $e->FormName($data["appids"]);
    $table->appnames = $e->FormName($data["appnames"]);
    $id = R::store( $table );
    return R::load( 'accountsystems', $id);
    // return $table;
}
function newentity($data)
{
    global $e;
    R::close();
    R::selectDatabase('ENTITY');
    $table = R::dispense('entity');

    $table->objid = "ENTITY:".md5(uniqid("ENTITY:",true));
    $table->office = $e->FormName($data["office"]);
    $table->lastname = $e->FormName($data["lastname"]);
    $table->firstname = $e->FormName($data["firstname"]);
    $table->middlename = $e->FormName($data["middlename"]);
    $table->suffix = isset($data["suffix"]) && $data["suffix"] != "none"? $e->FormName($data["suffix"]) : null ;
    $table->civilstatus = $e->FormName($data["civilstatus"]);
    $table->nationality = $e->FormName($data["nationality"]);
    $table->ethnicgroup = $e->FormName($data["ethnicgroup"]);
    $table->withchildren = $e->FormName($data["withchildren"]);
    $table->ispwd = $e->FormName($data["ispwd"]);
    $table->idmulticitizenship = $e->FormName($data["idmulticitizenship"]);
    $table->isipmember = $e->FormName($data["isipmember"]);
    $table->birthdate = $e->FormName($data["birthdate"]);
    $table->addresslotblock = $e->FormName($data["addresslotblock"]);
    $table->addresssubdivision = $e->FormName($data["addresssubdivision"]);
    $table->addresspurok = $e->FormName($data["addresspurok"]);
    $table->addressbarangay = $e->FormName($data["addressbarangay"]);
    $table->addresscitymun = $e->FormName($data["addresscitymun"]);
    $table->addressprovince = $e->FormName($data["addressprovince"]);
    $table->addressdistrict = $e->FormName($data["addressdistrict"]);
    $table->addressregion = $e->FormName($data["addressregion"]);
    $table->addresszipcode = $e->FormName($data["addresszipcode"]);
    $table->bloodtype = $e->FormName($data["bloodtype"]);
    $table->height = $e->FormName($data["height"]);
    $table->weight = $e->FormName($data["weight"]);
    $table->otherphysical = $e->FormName($data["otherphysical"]);


    $id = R::store( $table );
    return R::load( 'entity', $id);

}
