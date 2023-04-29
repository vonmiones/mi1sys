<?php
if (isset($_COOKIE)) {
	foreach ($_COOKIE as $key => $value) {
		setcookie($key,"");
	}
}
session_unset();
header("location:index.php");