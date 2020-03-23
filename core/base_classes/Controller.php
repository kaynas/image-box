<?php

namespace BaseClasses;

use Core;
abstract class Controller
{
    protected $view;
    protected $header_name = 'header_unreg.php';
    protected $auth;

    function __construct(){
        $this->view = new View();                   //создаём объект представления

        if(Core\Authorisation::$user['user_id']){   //Выбираем шапку сайта, в зависимости от того, зарегистрирован ли
            $this->header_name = 'header_reg.php';  //пользователь или нет
        }
    }
}