<?php
namespace Controller;

use BaseClasses\Controller;
use Model\ModelEdit;

class ControllerEdit extends Controller
{
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new ModelEdit();
    }

    public function Index($params){
        $pic_info = $this->model->GetPicInfo($params['params']);        //получаем информацию о картинке
        $data = ['params' => $params, 'content' => $pic_info];

        //Если в адресной страке не было параметра - id картинки или картинки с таким id не существует,
        //то выводится страница с ошибкой
        if($pic_info) {
            $this->view->render_page($params['view_name'] . '.php', $this->header_name, $data);
        }else{
            $this->view->render_page('no_image' . '.php', $this->header_name, $data);
        }
    }

    //Метод обновления инфорации о картинке пользователем
    public function Update($params){
        $this->model->Update($params['params']);
        $this->Index($params);
    }
}