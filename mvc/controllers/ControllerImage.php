<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 21.03.2020
 * Time: 21:04
 */

namespace Controller;


use BaseClasses\Controller;
use Core\Authorisation;
use Model\ModelImage;

class ControllerImage extends Controller
{
    protected $model;

    function __construct()
    {
        parent::__construct();
        $this->model = new ModelImage();
    }

    public function Index($params){
        session_start();
        //Если в URL не был передан id картинки, загружаем последнюю загруженную
        //Например, когда пользователь захотел залогиниться при просмотре изображения
        if($params['params']){
            $_SESSION['last_view_img'] = $params['params'];
        }else{
            $params['params'] = $_SESSION['last_view_img'];
        }

        $images = $this->model->GetImage($params['params']);            //Берём данные о выбранной картинке
        $data = ['params' => $params, 'content' => $images, 'notes' => ''];

        //Если картинка существует, то выводим ее, если нет, то сообщение об ошибке
        if($images) {
            if(!Authorisation::$user['user_id']){
                $data['notes'] = 'Зарегистрируйтесь или войдите под своим логином, для того чтобы оставлять комментарии!';
            }
            $this->model->IncreaseViewCount($params['params']);         //Увеличиваем счётчик просмотров на 1
            $this->view->render_page($params['view_name'] . '.php', $this->header_name, $data);
        }else{
            $this->view->render_page('no_image' . '.php', $this->header_name, $data);
        }
    }

    //Функция добавления комментария к картинке (только для зарегистрированных пользователей)
    public function Comment($params){
        if(Authorisation::$user['user_id']) {
            $this->model->Comment($params['params']);
        }
        $this->Index($params);
    }
}