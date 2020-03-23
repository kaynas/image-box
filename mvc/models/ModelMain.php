<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 18.03.2020
 * Time: 12:18
 */

namespace Model;


use BaseClasses\Model;
use Core\App;

class ModelMain extends Model
{
    //Поиск 6 самых новых картинок
    public function FindNewPic(){
        $user_pictures = [];
        $query_result = App::$db->query('
            SELECT *, (SELECT name FROM users WHERE users.id = pictures.user_id) as user_name
            FROM pictures
            ORDER BY pictures.date DESC
            LIMIT 6;
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

    //Поиск 6 самых популярных картинок
    public function FindPopularPic(){
        $user_pictures = [];
        $query_result = App::$db->query('
            SELECT *, (SELECT name FROM users WHERE users.id = pictures.user_id) as user_name
            FROM pictures
            ORDER BY pictures.view_count DESC
            LIMIT 6;
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

    //Поиск 6 случайных картинок
    public function FindRandomPic(){
        $user_pictures = [];
        $query_result = App::$db->query('
            SELECT *, (SELECT name FROM users WHERE users.id = pictures.user_id) as user_name
            FROM pictures
            ORDER BY rand()
            LIMIT 6;
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
}