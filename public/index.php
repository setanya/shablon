<?php
require_once '../system/core/function.php';//подключение файла
require_once '../system/core/Router.php';//подключение файла
require_once '../app/controllers/MainController.php';
$qStr = $_SERVER['QUERY_STRING'];
//путь в адесной строке
//pr($_REQUEST);//HTTPS - ЗАПРОС [page/home/ппо/4] =>В адресной строке

Router::add(['news/index'=>['controller'=>'news','action' =>'index']]);
Router::add(['page/home'=>['controller'=>'page','action' =>'home']]);
Router::add(['^$'=>['controller'=>'Main','action' =>'index']]);
// ^$ пустая строка
Router::add(['^(?P<controller>[a-z0-9-]+)/?(?P<action>[a-z0-9-]+)?$'=>[]]);//разрешаем передавать
//Router::add(['^([a-z0-9-]+)/([a-z0-9-]+)$'=>[]]);
//

pr(Router::$routers);//вид  [page/home] => Array([controller] => page[action] => home )

//Router::checkRouter($qStr);
pr(Router::$route);
Router::dispatch($qStr);//проверяем есть или нет контроллер