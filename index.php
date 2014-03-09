<?php
// 应用入口

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
// 设置开发模式，LOCAL使用本地模式，其他则是远程运行模式
define('DEV_MODE', 'LOCAL');
//define('DEV_MODE', 'REMOTE');
// 定义应用目录
define('APP_PATH','./Apps/');
// 定义模块绑定
$mapping = array(
	'LOCAL' => array(
		'108' => 'Web',
		'112' => 'Api',
		'118' => 'Control',
	),
	'REMOTE' => array(
		'api.f-fusion.com'  => 'Api',
		'shop.f-fusion.com' => 'Shop',
		'c.f-fusion.com'    => 'Control',
	),
);
// process
if (strcmp(constant('DEV_MODE'), 'LOCAL') == 0) {
	define('APP_DEBUG', true);
	define('APP_STATUS', 'local');
	$def = $mapping[constant('DEV_MODE')];
	$key = (string)substr($_SERVER['HTTP_HOST'], -3);
	if (array_key_exists($key, $def)) {
		define('BIND_MODULE', $def[$key]);
	};
};
if (strcmp(constant('DEV_MODE'), 'REMOTE') == 0) {
	define('APP_DEBUG', false);
	//define('APP_STATUS', 'remote');
	$def = $mapping[constant('DEV_MODE')];
	$key = (string)strtolower($_SERVER['HTTP_HOST']);
	if (array_key_exists($key, $def)) {
		define('BIND_MODULE', $def[$key]);
	};
};
if (defined('BIND_MODULE') === true) {
	// 引入ThinkPHP入口文件
	require './ThinkPHP/ThinkPHP.php';
};