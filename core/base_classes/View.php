<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 17.03.2020
 * Time: 16:39
 */

namespace BaseClasses;


class View
{
    public function render_page($content_view, $template_view, $data = []){
        include_once './mvc/views/templates/'.$template_view;         //загружаем общий шаблон, ему передаем контент вызываемой страницы
    }
}