<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 21.03.2020
 * Time: 13:44
 */

namespace Model;


use BaseClasses\Model;
use Core\App;

class ModelGallery extends Model
{
    //Функция выбирает все существующие картинки и информацию по ним
    public function FindAll(){
        $user_pictures = [];
        $query_result = App::$db->query('
            SELECT *, (SELECT name FROM users WHERE users.id = pictures.user_id) as user_name
            FROM pictures;
        ');
        foreach ($query_result as $row){
            $user_pictures[] = [
                'id' => $row['id'],
                'filename' => $row['pic_real_name'],
                'pic_address' => $row['pic_address'],
                'date' => $row['date'],
                'view_count' => $row['view_count'],
                'name' => $row['user_name']
            ];
        }
        return $user_pictures;
    }

    //Функция выбирает картинки по тегам или имени пользователя
    public function Search($tag, $user_name){
        $pictures = [];

        //Если оба поля заполнены
        $sql = '
            SELECT *, (SELECT name FROM users WHERE users.id = pictures.user_id) AS user_name
            FROM pictures, 
              (SELECT id AS temp_user_id FROM users WHERE name = ?) AS table_user_id, 
              (SELECT pic_id FROM tags WHERE tag = ?) AS table_tag_id
            WHERE pictures.user_id = table_user_id.temp_user_id AND pictures.id = table_tag_id.pic_id;
        ';
        $params_array = [$user_name, $tag];

        //Если оба поля пустые (выводятся все картинки)
        if(empty($tag) && empty($user_name)) {
            $sql = '
                SELECT *, (SELECT name FROM users WHERE users.id = pictures.user_id) AS user_name
                FROM pictures, 
                  (SELECT id AS temp_user_id FROM users WHERE name = name) AS table_user_id, 
                  (SELECT pic_id FROM tags WHERE tag = tag) AS table_tag_id
                WHERE pictures.user_id = table_user_id.temp_user_id AND pictures.id = table_tag_id.pic_id;
            ';
            $params_array = [];
        }elseif(empty($tag)){                   ///Если заполнено поле "Имя пользователя"
            $sql = '
                SELECT *, (SELECT name FROM users WHERE users.id = pictures.user_id) as user_name
                FROM pictures, 
                  (SELECT id as temp_user_id FROM users WHERE name = ?) as table_user_id, 
                  (SELECT pic_id FROM tags WHERE tag = tag) as table_tag_id
                WHERE pictures.user_id = table_user_id.temp_user_id AND pictures.id = table_tag_id.pic_id;
            ';
            $params_array = [$user_name];
        }elseif(empty($user_name)){             //Если заполнено поле "Тег"
            $sql = '
                SELECT *, (SELECT name FROM users WHERE users.id = pictures.user_id) as user_name
                FROM pictures, 
                  (SELECT id as temp_user_id FROM users WHERE name = name) as table_user_id, 
                  (SELECT pic_id FROM tags WHERE tag = ?) as table_tag_id
                WHERE pictures.user_id = table_user_id.temp_user_id AND pictures.id = table_tag_id.pic_id;
            ';
            $params_array = [$tag];
        }

        $query_result = App::$db->prepare($sql);
        $query_result->execute($params_array);

        foreach ($query_result as $row){
            $pictures[] = [
                'id' => $row['id'],
                'filename' => $row['pic_real_name'],
                'pic_address' => $row['pic_address'],
                'date' => $row['date'],
                'view_count' => $row['view_count'],
                'name' => $row['user_name']
            ];
        }
        return $pictures;
    }
}