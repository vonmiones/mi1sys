<?php
use  framework\core\modules;
global $modmenu;
global $page;
global $fn;
global $ds;
global $form;
global $route;
$modmenu = "";
$page = isset($_GET['page'])?$_GET['page']:"dashboard";
$fn = isset($_GET['fn'])?$_GET['fn']:"";
$ds = isset($_GET['ds'])?$_GET['ds']:"";
$form = isset($_GET['form'])?$_GET['form']:"";
$admin = new modules\AdminView();