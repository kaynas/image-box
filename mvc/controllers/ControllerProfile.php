<?php
namespace Controller;

use BaseClasses\Controller;
use Model\ModelProfile;

class ControllerProfile extends Controller
{
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new ModelProfile();
    }

    public function Index($params){
        $images = $this->model->FindAll();
        $data = ['params' => $params, 'content' => $images];
        $this->view->render_page($params['view_name'] . '.php', $this->header_name, $data);
    }

    public function Add($params){
        if(isset($_FILES['file_field']) && $_FILES['file_field']['tmp_name'][0] != ''){ //если были переданы файлы картинок
            foreach ($_FILES['file_field']['tmp_name'] as $file_name){                  //то они добавляются в базу
                $this->model->Add($file_name);
            }
            unset($_FILES['file_field']);
        }

        $this->Index($params);
    }

    //Функция удаления всех выбранных файлов
    public function Delete($params){
        if(isset($_POST['checkbox']) && $_POST['checkbox'][0] != ''){
            $this->model->Delete($_POST['checkbox']);
        }

        $this->Index($params);
    }
}