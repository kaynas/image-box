<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 21.03.2020
 * Time: 13:43
 */

namespace Controller;


use BaseClasses\Controller;
use Model\ModelGallery;

class ControllerGallery extends Controller
{
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new ModelGallery();
    }
    public function Index($params){
        //Выводим все картинки галереи
        //либо выводим картинки по поиску
        if(empty($_POST['tag']) && empty($_POST['user_name'])) {
            $gallery = $this->model->FindAll();
        }else{
            $gallery = $this->model->Search($_POST['tag'], $_POST['user_name']);
        }

        $content['gallery'] = $gallery;
        $content['tags'] = $this->model->SearchPopularTags();           //Ищем 10 самых популярных тегов
        $content['users'] = $this->model->SearchPopularUsers();         //Ищем 10 самых популярных пользователей
        $data = ['params' => $params, 'content' => $content];
        $this->view->render_page($params['view_name'] . '.php', $this->header_name, $data);
    }
}