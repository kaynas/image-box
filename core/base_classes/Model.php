<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 17.03.2020
 * Time: 16:39
 */

namespace BaseClasses;

use Core;
abstract class Model
{
    //Функция ищет пользователя по полям таблицы 'users'
    protected function FindUser($field, $value){
        return Core\App::$db->query('SELECT * FROM users WHERE '.$field.' = "'.$value.'";');
    }

    //функция ищет 10 самых просматриваемых тегов
    public function SearchPopularTags(){
        $popular_tags = [];
        $query_result = Core\App::$db->query('
            SELECT SUM(pictures.view_count) as count, tags.tag as tag
            FROM pictures, tags
            WHERE pictures.id = tags.pic_id
            GROUP BY tag
            ORDER BY count DESC
            LIMIT 10;
        ');
        foreach ($query_result as $row){
            $popular_tags[] = [
                'tag' => $row['tag'],
                'count' => $row['count']
            ];
        }

        return $popular_tags;
    }

    //функция ищет 10 самых просматриваемых пользователей
    public function SearchPopularUsers(){
        $popular_users = [];
        $query_result = Core\App::$db->query('
            SELECT SUM(pictures.view_count) as count, users.name as user
            FROM pictures, users
            WHERE pictures.user_id = users.id
            GROUP BY user
            ORDER BY count DESC
            LIMIT 10;
        ');
        foreach ($query_result as $row){
            $popular_users[] = [
                'user_name' => $row['user'],
                'count' => $row['count']
            ];
        }

        return $popular_users;
    }
}