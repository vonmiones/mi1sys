<?php
header('Content-Type: application/json; charset=utf-8');
$page = isset($_GET['page'])?$_GET['page']:"error";
$fn = isset($_GET['fn'])?$_GET['fn']:"";

if ($page != "" && $fn != "") {
	$route = "$page/$fn.php";
}elseif ($page != "") {
	$route = "$page/json.php";
}
else{
	$route = "error/json.php";
}



