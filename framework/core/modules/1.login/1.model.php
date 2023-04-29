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
class AccountLoginModel
{
	

	function __construct()
	{
		self::init();
	}
	function init()
	{
		R::addDatabase('LOGIN','mysql:host='.SYSTEMDBHOST.';dbname='.SYSTEMDBNAME.'_accounts',SYSTEMDBUSER, SYSTEMDBPASS );
		R::selectDatabase('LOGIN');
		R::close();
	}

	function getLoginCredentials($u,$p)
	{
		$token = new NameTokenizer();
		$pdo = R::getPDO();
	    $writer = R::getWriter();
	    $table = 'accountlogin';
	    $uid = "";
	    $user = $token->FormName($u);
	    $pass = $token->FormName($p);
	    // die("$user : $pass");
	    $result = R::getRow(
	    	'SELECT * FROM '.$writer->esc($table).'WHERE'.
	    	' user = '. $pdo->quote($user).
	    	' AND '.
	    	' pass = '. $pdo->quote($pass).
	    	' LIMIT 1' ,[]);
	    if (isset($result) && count($result)>0) {
	    	generateShortSession();
	    	$uid = sprintf('%08d', $result['id']);
	    	$st =  $token->FormName( sprintf('%08d', $result['id']))."-".$result['role'] . '' . uniqid();
	    	// $_SESSION['_uid'] = $uid;
	    	setcookie("_uid", $uid);
	    	setcookie("_st", $st);
	    	return true;
	    }else{
	    	if (isset($_SESSION)) {
				session_destroy();
	    	}
	    	return false;
	    }

	}

	function GetLoginAccounts()
	{
		R::selectDatabase( 'LOGIN' );
		return R::getAll( 'SELECT * FROM accountlogin' );
	}
}
