<?php

// прописывается таблица маршрутов
class Router
{
    public static $routers = [];//массив с маршрутами
    public static $route = [];//конкретный маршрут


/**для заполнения массива с маршрутами
 * //получает массив и записывает в таблицу маршрутов $routers = []
 * как ключ значение, если найдено совпадение выведется представление
**/
    public static function add($route)
    {
        foreach ($route as $key =>$val){
            self::$routers[$key] = $val;
            //  функция получает массив и записывает в многомерный массив $routers = []
        ////вид  [page/home] => Array([controller] => page[action] => home )
        }
    }
/**передаем $url - адресная строка
 * метод  ищет совпадения в таблице маршрутов
 * на вход адресная строка возвращает да или нет
 **/
    public static function checkRouter($url)
    {
        foreach (self::$routers as $k => $val){
            if ( preg_match("#$k#i", $url, $matches)){//если ключ совпадает с $url
                pr($matches);
                $route = $val;
                // i -регистр независимости
                //#$k#  это искомый шаблон
                foreach ($matches as $key => $match){
                    if(is_string($key)){//еали это строка
                        $route[$key]= $match;//если
                    }
                }
                $route['controller'] = self::uStr($route['controller']);//перезаписали правильное значение значения
                if(!isset($route['action'])){//если нет action тогда использовать метод index
                    $route['action'] = 'index';//устанавливаем  по умолчанию
                }
                self::$route = $route; //если маршруты найдены записываем в переменную $route
                return true; //есло совпадение найдены цыкл заканчивается
            }
        }
        return false;
    }

   public static function dispatch($path)//метод для получения  конкретного controllera и его метода
    {//если обращяемся к классу  его метод
        if(self::checkRouter($path)){
            //если страница существует
            $controller ='\app\controllers\\' . self::$route['controller'] . 'Controller';//чтобы взять нужный контроллер
            if(class_exists($controller)){//class_exists проверяет если класс существует
                $obj = new $controller;//создаем обьект этого класса
            }else{
                echo 'Контроллер'. $controller . 'не найден';
            }
        }else{
            //если страница не существует
            echo '404';
        }
    }

    /**
     * @param $str //функция для обработки в адресной строке
     * убираем дефис, переводим первые буквы в заглавные и ебираем пробел между словами
     * @return array|string|string[]
     */
    private static function uStr($str)
    {
        $str = str_replace('-',' ', $str);//если есть дефис заменяем на пробел
        $str = ucwords($str);//все слова с большой буквы
        $str = str_replace(' ','', $str);// пробел между словами убираем
        return $str;
    }
}