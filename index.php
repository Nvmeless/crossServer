<?php
define('WEBROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']) .'public/');
define('APP', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']). 'public/App/');
define('MODEL', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']). 'public/Models/');
require(APP.'connect.php');
require(APP.'Model.php');

$params = explode('/', $_GET['p']);
$UserModelt = Model::load($params[0]);
$UserModelt->getPage(['id' => $params[2]]);

