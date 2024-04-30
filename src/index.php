<?php

require_once __DIR__ . '/controller/registerController.php';
require_once __DIR__ . '/controller/homeController.php';
require_once __DIR__ . '/controller/loginController.php';
require_once __DIR__ . '/controller/profilController.php';
require_once __DIR__ . '/controller/shopController.php';

require_once __DIR__ . '/database/database.php';

//definir une varibale globale en verifiant les session des user.


$routes = [
    '/' => ['controller' => "homeController", 'method' => "home"],
    '/register' => ['controller' => "registerController", 'method' => "register"],
    '/login' => ['controller' => "loginController", 'method' => "login"],
    '/profil' => ['controller' =>"profilController", 'method' => "profil"],
    '/shop' => ['controller' => "shopController", "method" => "shop"],
];

$requestParts = explode('?', $_SERVER['REQUEST_URI'], 2);
$path = $requestParts[0];

if (array_key_exists($path, $routes)) {
  $controllerName = $routes[$path]['controller'];
  $methodName = $routes[$path]['method'];

  $controller = new $controllerName();
  $params = isset($requestParts[1]) ? $requestParts[1] : '';
  $controller->$methodName();
} else {
}