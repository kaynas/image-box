<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 21.03.2020
 * Time: 21:04
 */

namespace Model;


use BaseClasses\Model;
use Core\App;
use Core\Authorisation;

class ModelImage extends Model
{
    //Функция отдаёт информацию по id картинке
    public function GetImage($pic_id){
        if($pic_id) {
            //Проверяем, есть ли картинка с таким id
            $sql = 'SELECT * FROM pictures WHERE id = ?;';
            $query_result = App::$db->prepare($sql);
            $query_result->execute([$pic_id]);
            $query_result = $query_result->fetch(\PDO::FETCH_ASSOC);

            //Если есть, запрашиваем из базы информацию по ней
            if ($query_result['id']) {
                $picture = [
                    'id' => $query_result['id'],
                    'filename' => $query_result['pic_real_name'],
                    'pic_address' => $query_result['pic_address'],
                    'title' => $query_result['title'],
                    'comments' => []
                ];

                //Запрашиваем пользовательские комментарии к этой картинке
                $sql = '
                    SELECT users.name AS name, comments_table.comment AS text
                    FROM users, (SELECT comments.* FROM comments WHERE comments.pic_id = ?) AS comments_table 
                    WHERE users.id = comments_table.user_id;
                ';
                $query_result = App::$db->prepare($sql);
                $query_result->execute([$pic_id]);

                foreach ($query_result as $row) {
                    $picture['comments'][] = ['user_name' => $row['name'], 'comment' => $row['text']];
                }

                return $picture;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    //Функция добавляет пользовательский комментарий к картинке
    public function Comment($pic_id){
        if($pic_id){
            $sql = 'SELECT id FROM pictures WHERE id = ?;';
            $query_result = App::$db->prepare($sql);
            $query_result->execute([$pic_id]);
            $query_result = $query_result->fetch(\PDO::FETCH_ASSOC);

            if ($query_result['id']) {
                $insert_comment_query = '
                    INSERT INTO comments (user_id, pic_id, comment, date)          
                    VALUES (?,?,?,?);
                ';
                $statement = App::$db->prepare($insert_comment_query);

                $statement->execute([
                    Authorisation::$user['user_id'],
                    $pic_id,
                    $_POST['user_comment'],
                    date('Y-m-d', time())
                ]);
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //Функция увеличивает счетчик просмотров
    public function IncreaseViewCount($pic_id){
        $sql = 'SELECT view_count FROM pictures WHERE id = ?;';
        $query_result = App::$db->prepare($sql);
        $query_result->execute([$pic_id]);
        $query_result = $query_result->fetch(\PDO::FETCH_ASSOC);
        $query_result['view_count'] += 1;

        $update_img_query = '
                UPDATE pictures 
                SET view_count = ?
                WHERE id = ?;
            ';

        $statement = App::$db->prepare($update_img_query);
        $statement->execute([$query_result['view_count'], $pic_id]);
    }
}