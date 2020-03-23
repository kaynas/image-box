<?php
namespace Controller;

use BaseClasses\Controller;
use Core\Authorisation;

class ControllerRegistration extends Controller
{
    //вывод страницы регистрации
    public function Index($params){
        $data = ['params' => $params, 'content' => []];
        $this->view->render_page($params['view_name'] . '.php', $this->header_name, $data);
    }
}