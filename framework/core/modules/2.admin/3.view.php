<?php
namespace framework\core\modules;
/**
 * 
 * Module Name: System Accont Login
 * Date Created: December 05, 2021 08:58 PM
 * Author: Von Microbert T. Miones
 * Updates:
 * --------------------------------------------------------
 * 03/30/2022
 * - Moved Admin registration form from Themes to Core
 * - Added User Account Registration
 * 	 - Save button will only be available as soon as the password is filled
 * - Added Account Role Options
 *   - Option will not be available as soon as the user will register
 * - Some bug Fixes
 * --------------------------------------------------------
 */
class AdminView
{	
	function __construct()
	{
		self::init();
	}

	function init(){
		global $modmenu;
		global $page;
		global $fn;
		global $ds;
		global $form;
		global $route;
		if ($page != "" && $fn != "") {
			$route = "$page/$fn.php";
			$modmenu = "$page/menu.php";
		}elseif ($page != "" && $ds == "api") {
			$route = "$page/ds.api.php";
			include $route;
			die();
		}elseif ($form != "") {
			$route = "$page/$form.php";
			include $route;
			die();
		}elseif ($page != "") {
			$route = "$page/dashboard.php";
			$modmenu = "$page/menu.php";
		}
		else{
			$modmenu = "";
			$route = "dashboard/dashboard.php";
		}
	}
}
