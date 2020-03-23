<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 22.03.2020
 * Time: 20:56
 */

namespace Controller;


use BaseClasses\Controller;

class ControllerError404 extends Controller
{
    public function Index($params){
        $data = ['params' => $params, 'content' => []];
        $this->view->render_page($params['view_name'] . '.php', $this->header_name, $data);
    }
}