<?php

$modmenu = "";
$page = isset($_GET['page'])?$_GET['page']:"dashboard";
$fn = isset($_GET['fn'])?$_GET['fn']:"";
$ds = isset($_GET['ds'])?$_GET['ds']:"";
$form = isset($_GET['form'])?$_GET['form']:"";


if ($page != "" && $fn != "") {
	$access = "$page/$fn.php";
	$modmenu = "$page/menu.php";
}elseif ($page != "" && $ds == "api") {
	$access = "$page/ds.api.php";
	include $access;
	die();
}elseif ($form != "") {
	$access = "$page/$form.php";
	include $access;
	die();
}elseif ($page != "") {
	$access = "$page/dashboard.php";
	$modmenu = "$page/menu.php";
}
else{
	$modmenu = "";
	$access = "dashboard/dashboard.php";
}