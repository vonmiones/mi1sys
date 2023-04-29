<?php

/** 
 * Server Date and Time Settings 
 */

$conf["enable_ntp_service"] = false;
$conf["ntp_host"] = "";
$conf["ntp_timezone"] = "Asia/Manila";

/**
 * Licensing 
 */

$conf["licensekey"] = "vonmiones";
$conf["licensetoken"] = "";
$conf["licensee"] = "";
$conf["apitoken"] = "";
$conf["apikey"] = "";
$conf["dateseries"] = date("Y");

/**
 *
 * System Database Settings 
 * Update: Dec 02, 2021
 * Modular App Database Settings will Configured Separately
 *
 *
 *
 *
 *
 *
 */

// Added: Dec 02, 2021
$conf["dbbalance"] = true; // USE MULTIPLE DATABASE BALANCER

$conf["dbtype"] = ""; 
$conf["dbhost"] = "localhost";
$conf["dbname"] = "mi1_sys";
$conf["dbuser"] = "root";
$conf["dbpass"] = "";
$conf["initial"] = true; // Default is TRUE; When database has no content; It will automatically initializes the masterfiles

/**
 * Logging Service 
 */
$conf["enable_log_service"] = false;
$conf["log_path"] = "log/";
$conf["require"] = ["login"];

/**
 * Template 
 */
$conf["template"] = "default";
$conf["template_use_vendor"] = true;
$conf["template_style_vendor"] = "bootstrap";


// DEFAULT APPLICATION
$conf["appdefault"] = "entitymoph";

// CONSTANT

// TEMPLATE CONSTANT
define('TEMPLATE', $conf["template"]);

define('APP', $conf["appdefault"]);

// LISENSING CONSTANT
define('LICENSEKEY',$conf["licensekey"]);
define('LICENSETOKEN',$conf["licensetoken"]);
define('LICENSEE',$conf["licensee"]);
define('APITOKEN',$conf["apitoken"]);
define('APIKEY',$conf["apikey"]);

define('SYSTEMDBTYPE', $conf["dbtype"]);
define('SYSTEMDBHOST', $conf["dbhost"]);
define('SYSTEMDBNAME', $conf["dbname"]);
define('SYSTEMDBUSER', $conf["dbuser"]);
define('SYSTEMDBPASS', $conf["dbpass"]);