<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 17.03.2020
 * Time: 17:12
 */

namespace Controller;


use BaseClasses\Controller;
use Model\ModelMain;

class ControllerMain extends Controller
{
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new ModelMain();
    }

    public function Index($params){
        $data = ['params' => $params, 'content' => []];
        $data['content']['new_pic'] = $this->model->FindNewPic();               //Ищем 6 новейших картинок
        $data['content']['popular_pic'] = $this->model->FindPopularPic();       //Ищем 6 самых популярных картиное
        $data['content']['random_pic'] = $this->model->FindRandomPic();         //Ищем 6 случайных картинок
        $data['content']['tags'] = $this->model->SearchPopularTags();           //Ищем 10 самых популярных тегов
        $data['content']['users'] = $this->model->SearchPopularUsers();         //Ищем 10 самых популярных пользователей

        $this->view->render_page($params['view_name'] . '.php', $this->header_name, $data);
    }
}