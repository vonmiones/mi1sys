<?php
namespace framework\core\modules;

/**
 * Menu View
 */
class MenuView
{	
	function __construct()
	{

	}
	function headerMenu(){
		$m = ["Home","About Me","Help","Contact"];
		return $m;
	}
	function leftSidebarMenu(){
		$kvm = array(
			'Home' => array("nc-bank","#"), 
			'Manage Users' => array("nc-single-02","#"),
			'Manage Map' => array("fa-duotone fa-address-card","#")

		);
		return $kvm;
	}
}
?>