<?php
global $conf;
require_once 'config/settings.php';
date_default_timezone_set($conf["ntp_timezone"]);
require_once 'framework/core/init/boot.php';