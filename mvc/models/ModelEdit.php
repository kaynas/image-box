<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 21.03.2020
 * Time: 10:22
 */

namespace Model;


use BaseClasses\Model;
use Core\App;
use Core\Authorisation;

class ModelEdit extends Model
{
    //Функция выборки данных для режима редактирования
    public function GetPicInfo($pic_id){
        if($pic_id) {
            //Проверяем, есть ли картинка с данным id
            $sql = '
                SELECT pic_real_name, pic_address, title
                FROM pictures
                WHERE id = ? AND user_id = ' . Authorisation::$user['user_id'] . ';
            ';
            $query_result = App::$db->prepare($sql);
            $query_result->execute([$pic_id]);
            $query_result = $query_result->fetch(\PDO::FETCH_ASSOC);

            if ($query_result['pic_real_name']) {
                //Если картинка существует, получаем данные
                $pic_info = [
                    'pic_id' => $pic_id,
                    'pic_name' => $query_result['pic_real_name'],
                    'pic_address' => $query_result['pic_address'],
                    'comment' => $query_result['title'],
                    'tags' => []
                ];

                //Запрашиваем все теги этой картинки
                $sql = '
                    SELECT id, tag
                    FROM tags
                    WHERE pic_id = ?;
                ';
                $query_result = App::$db->prepare($sql);
                $query_result->execute([$pic_id]);

                foreach ($query_result as $row) {
                    $pic_info['tags'][$row['id']] = $row['tag'];
                }

                return $pic_info;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    //Функция обновляет данные о картинке (изменённые пользователем)
    public function Update($pic_id){
        //Проверяем картинку на наличие
        $sql = '
            SELECT id
            FROM pictures
            WHERE id = ? AND user_id = ' . Authorisation::$user['user_id'] . ';
        ';
        $query_result = App::$db->prepare($sql);
        $query_result->execute([$pic_id]);
        $query_result = $query_result->fetch(\PDO::FETCH_ASSOC);

        if($query_result['id']){
            //Если было изменено поле "Комментарий владельца", заносим в базу комментарий
            if(isset($_POST['comment'])) {
                $update_comment_query = '
                    UPDATE pictures 
                    SET title = ?
                    WHERE id = ' . $pic_id . ' AND user_id = '.Authorisation::$user['user_id'].';
                ';
                $statement = App::$db->prepare($update_comment_query);

                $statement->execute([
                    $_POST['comment']
                ]);
            }

            //Добавляем новый тег к картинке
            if(!empty($_POST['tag'])){
                //Если тег уже существует, не добавляем
                $sql = '
                    SELECT id
                    FROM tags
                    WHERE pic_id = ? AND tag = ?;
                ';
                $query_result = App::$db->prepare($sql);
                $query_result->execute([$pic_id, $_POST['tag']]);

                $query_result = $query_result->fetch(\PDO::FETCH_ASSOC);
                if(!$query_result['id']) {
                    $insert_tag_query = '
                        INSERT INTO tags (pic_id, tag)          
                        VALUES (?,?);
                    ';
                    $statement = App::$db->prepare($insert_tag_query);

                    $statement->execute([
                        $pic_id,
                        $_POST['tag']
                    ]);
                }
            }

            //Удаляем выбранные теги
            if(isset($_POST['delete_tags']) && $_POST['delete_tags'][0] != ''){
                foreach ($_POST['delete_tags'] as $tag_id) {
                    App::$db->query('DELETE FROM tags WHERE id=' . $tag_id . ';');
                }
            }

            return true;
        }else{
            return false;
        }
    }
}