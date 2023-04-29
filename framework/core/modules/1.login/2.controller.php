<?php
use framework\core\libs\common\handler as Handler;

/**
 * 
 * Module Name: System Accont Login
 * Date Created: December 05, 2021 08:58 PM
 * Author: Von Microbert T. Miones
 * 
 */
global $Account;
global $SystemSecurity;
global $isLoginSuccess;
$Account = new AccountLoginModel();
$SystemSecurity = new Handler\SystemSecurity();
$token = new NameTokenizer();
$filter = new AntiXSS();
$isLoginSuccess = null;


function GetLoginAccounts()
{
	global $Account;
	return $Account->GetLoginAccounts();
}

function validateFormName($user,$pass)
{
    if ($user == "user" && $pass == "pass" ) {
        return true;
    }else{
        return false;
    }
}

function validateLogin($user,$pass)
{
    global $Account;
    return $Account->getLoginCredentials($user,$pass);
}
// if (!isset($_COOKIE['PHPSESSID']) && !isset($_COOKIE['_uid'])) {
// }
$post = isset($_POST) ? $_POST : [];
if (count($post)>0) {
    if (trim(substr(array_keys($post)[0],0,1)) === "v") {
        $userName = explode(':',$token->FormName( substr(array_keys($post)[0],1),"decrypt"))[0];
        $passName = explode(':',$token->FormName( substr(array_keys($post)[1],1),"decrypt"))[0];
        $user = "";
        $pass = "";
        if (validateFormName($userName,$passName)) {
            if (isset($post)) {
                $user = StripQuoteTags( $post[ array_keys($post)[0] ] );
                $pass = StripQuoteTags( $post[ array_keys($post)[1] ] );
                $isLoginSuccess = validateLogin($user,$pass);
                if ($isLoginSuccess == true) {
                    header("location:index.php");
                }
            }
        }
    }
}