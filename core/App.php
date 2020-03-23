<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 17.03.2020
 * Time: 15:20
 */

namespace Core;

class App
{
    //Класс App загружает основные классы и вызывает необходимый контроллер

    protected $router;
    protected $auth;
    public static $db;
    protected $defaultControllerName = 'Main';
    protected $defaultActionName = "Index";

    function __construct(){
        $this->router = new Router();           //Создаем маршрутизатор
        $this->auth = new Authorisation();      //Создаем объект класса авторизации

        //Создаем подключение к БД
        self::$db = new \PDO(DSN, USER, PASS);
        self::$db->setAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
    }

    public function launch()
    {
        list($controllerName, $actionName, $params) = $this->router->active();
        echo $this->launchAction($controllerName, $actionName, $params);
    }

    protected function launchAction($controllerName, $actionName, $params)
    {
        //Обработка запросов авторизации
        switch ($actionName){
            case 'login':
                $params['errors']['login_errors'] = $this->auth->Login($_POST['email'], $_POST['pass']);
                unset($_POST['email']);
                unset($_POST['pass']);
                $actionName = '';
                break;

            case 'logout':
                $this->auth->Logout();
                $actionName = '';
                break;

            case 'registrate':
                $params['errors']['reg_errors'] = $this->auth->Registrate();
                $actionName = '';
                break;
        }

        //Проверка на право доступа к странице и на наличие имени контроллера в запросе
        //Если в доступе отказано или нет имени контроллера, загружается главная
        if(empty($controllerName) || !$this->auth->Access($controllerName)){
            $controllerName = $this->defaultControllerName;
        }

        $params['view_name'] = $controllerName;
        $params['user_name'] = Authorisation::$user['user_name'];
        $controllerName = ucfirst($controllerName);

        //Проверяем, существует ли файл контроллера, если нет, выводим 404 страницу
        if(!file_exists('mvc/controllers/Controller'.$controllerName.'.php')){
            $controllerName = 'Error404';
            $params['view_name'] = $controllerName;
            $params['user_name'] = Authorisation::$user['user_name'];
            $actionName = 'Index';
        }

        $controllerName = "\\Controller\\Controller".ucfirst($controllerName);
        $controller = new $controllerName();
        $actionName = empty($actionName) ? $this->defaultActionName : $actionName;

        //Проверяем, существует ли метод у данного контроллера, если нет, выводим 404 страницу
        if (!method_exists($controller, $actionName)){
            $controllerName = 'Error404';
            $params['view_name'] = $controllerName;
            $params['user_name'] = Authorisation::$user['user_name'];
            $actionName = 'Index';
        }

        //Запускаем метод контроллера с параметром
        return $controller->$actionName($params);
    }
}