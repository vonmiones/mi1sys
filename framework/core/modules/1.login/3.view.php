<?php
global $isLoginSuccess;
setcookie("__p", sha1(uniqid()));
// $proceed = true; // Default = false, set true and add die() function after it to skip the login process;
// die();
if (isset($_GET['device']) && $_GET['device'] == "desktop") {
    $proceed = true;
}else{
    if (isset($_COOKIE['_uid'])) {
        	$proceed = true;
    }else {
        require 'form/form.php';
        $proceed = false;
        // echo "<script>alert('Login Failed');</script>>";       
    }
    if ($proceed == false) {
        die();
    }
}


