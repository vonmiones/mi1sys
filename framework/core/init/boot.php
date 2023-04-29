<?php
require_once 'autoload.php';
global $redis;
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->select(0);
try {
    try {
        $el = new framework\core\libs\common\FileSystem;
        $content = new framework\core\libs\common\FileSystem;
        foreach ($el->getLibClass("framework/core/libs/common/handler") as $key => $v) {
            foreach ($el->getLibClass($v."/*") as $m) {
                require $m;
            }
        }
        foreach ($el->getLibClass("framework/core/modules/*") as $key => $v) {
            foreach ($el->getLibClass($v."/*") as $m) {
                if (!is_dir($m)) {
                    require $m;
                }
            }
        }

        $template =new framework\core\libs\common\Template(isset($conf["template"])?$conf["template"]:null);

    } catch (Exception $e) {
        echo $e->getMessage(), "\n";
    }
} catch (Exception $e) {
    echo $e->getMessage(), "\n";
}