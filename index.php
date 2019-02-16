<?php
if (version_compare(PHP_VERSION, '5.3.0') == -1) {
	exit("系统运行所需PHP版本需要大于5.3！");
}
error_reporting(E_ALL & ~E_NOTICE);
session_start();
// 应用目录为当前目录
define('APP_PATH', dirname(__FILE__) . '/');

// 加载框架文件
require(APP_PATH . 'core/framework.php');

// 加载配置文件
$config = require(APP_PATH . 'config/config.php');

// 实例化框架类
$app = new Framework($config);

$app->run();
?>