<?php

namespace Core;

class Router
{
    //Функция маршрутизатора. Адрес состоит из трёх частей: название контроллера/название функции/параметр
    public function active(){
        $route = $_SERVER['REQUEST_URI'];
        $route = explode('/', $route);

        $params = [
            'errors' => [                                   //здесь хранятся описания ошибок авторизации
                'login_errors' => [],
                'reg_errors' => []
            ],
            'view_name' => '',                              //название загружаемого шаблона
            'user_name' => '',                              //имя пользователя (для передачи в шапку сайта)
            'params' => empty($route[3]) ? '' : $route[3]   //параметр передаваемый в контроллер (id фото)
        ];

        $result[0] = $route[1];
        $result[1] = $route[2];
        $result[2] = $params;
        return $result;
    }
}