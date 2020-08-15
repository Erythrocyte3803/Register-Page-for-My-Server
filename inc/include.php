<?php
//加载配置文件
require_once $_SERVER['DOCUMENT_ROOT'] ."/config.php";
//加载所有类
spl_autoload_register("_autoload");
function _autoload($classname) {
    require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/classes/" . strtolower($classname) . ".php");
}
$db = new database();