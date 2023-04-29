<?php 
global $conf;
use framework\core\modules as Module;
$menu = new Module\MenuView();
$headerMenu = $menu->headerMenu();
$leftMenu = $menu->leftSidebarMenu();

/**
 * ROUTER
 * 
 * 
 */
if (isset($_GET['route'])) {
    if ($_GET['route'] == "admin") {
        require "themes/". $conf["template"]."/admin/wrapper.php"; 
    }elseif($_GET['route'] == "api"){
        require "themes/". $conf["template"]."/api/wrapper.php"; 
    }
    else{
        require "themes/". $conf["template"]."/elements/wrapper.php"; 
    }
}else{
        require "themes/". $conf["template"]."/elements/wrapper.php"; 
}
?>
