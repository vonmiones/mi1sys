<?php

require_once 'boot/loader.php';
$a=0;
$var=0;

if (isset($_GET["error"])) {
	if ($_GET["error"] == 404) {
		echo "PAGE NOT FOUND";
	}
}
