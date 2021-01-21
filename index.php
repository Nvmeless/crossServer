<?php
define('WEBROOT',str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']) .'public/');
define('APP', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']). 'public/App/');
define('MODEL', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']). 'public/Models/');
define('CONTROLLER', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']). 'public/Controllers/');
define('VIEW', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']). 'public/Views/');
require(APP.'connect.php');
require(APP.'Model.php');
require(APP.'Controller.php');
require(APP.'Error.php');
$params = explode('/', $_GET['p']);
$controller = $params[0];
if(file_exists(CONTROLLER. $controller. '.php')){ 
    $action = $params[1] ?? "index";
    require(CONTROLLER. $controller. '.php');
    
    
    $controller = new $controller();

    if(method_exists($controller,$action)){
        unset($params[0]);
        unset($params[1]);
        call_user_func_array(array($controller, $action),$params);
    }else{
        echo'erreur 501';
    }
}else{
    echo'erreur 404';
}