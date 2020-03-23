<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 20.03.2020
 * Time: 13:30
 */

namespace Model;


use BaseClasses\Model;
use Core\App;
use Core\Authorisation;

class ModelProfile extends Model
{
    //Функция добавления новой картинки
    public function Add($filename){
        //Создаем запись в БД
        $insert_img_query = '
                INSERT INTO pictures (user_id, pic_real_name, pic_address, date, view_count)          
                VALUES (?,?,?,?,?);
            ';
        $statement = App::$db->prepare($insert_img_query);

        $statement->execute([
            Authorisation::$user['user_id'],
            '',
            '',
            date('Y-m-d', time()),
            0
        ]);

        //Получаем ID записи и не его основе будем строить путь к картинке и название картинки
        $pic_id = App::$db->lastInsertId();
        $filepath = 'upload/' . Authorisation::$user['user_name'] .'/'. $pic_id;
        $new_filename = $pic_id . '.jpg';

        //Сжимаем картинки до нужных размеров
        //На выходе будет 2 картинки: маленькая, для предпоказа и большая
        $this->ResizeImg($filename, $filepath, $new_filename, 278, 'small');
        $this->ResizeImg($filename, $filepath, $new_filename, 1024, 'big');

        //Сохраняем пути к созданным картинкам
        $update_img_query = '
                UPDATE pictures 
                SET pic_real_name = ?, pic_address = ?
                WHERE id = '.$pic_id.';
            ';
        $statement = App::$db->prepare($update_img_query);

        $statement->execute([
            $new_filename,
            $filepath
        ]);
    }

    //Функция удаления выбранных картинок
    public function Delete($pic_id_array = []){
        foreach ($pic_id_array as $id){
            $query_result = App::$db->query('SELECT pic_address FROM pictures WHERE id = '.$id.' AND user_id = '.Authorisation::$user['user_id'].';');
            $query_result = $query_result->fetch(\PDO::FETCH_ASSOC);

            //Удаляем директорию и картинки
            self::RemoveDir($query_result['pic_address']);

            App::$db->query('DELETE FROM pictures WHERE id='.$id.';');
        }
    }

    //Функция поиска всех картинок данного пользователя
    public function FindAll(){
        $user_pictures = [];
        $query_result = App::$db->query('SELECT * FROM pictures WHERE user_id = '.Authorisation::$user['user_id'].';');
        foreach ($query_result as $row){
            $user_pictures[] = [
                'id' => $row['id'],
                'filename' => $row['pic_real_name'],
                'pic_address' => $row['pic_address'],
                'date' => $row['date'],
                'view_count' => $row['view_count']
            ];
        }
        return $user_pictures;
    }

    //Функция ресайза изображения
    private function ResizeImg($filename, $filepath, $new_filename, $width, $size_type){

        $image = new \Imagick($filename);
        $image->setImageFormat ("jpeg");
        $image->adaptiveResizeImage($width,0);

        mkdir($filepath . '/'.$size_type.'/', 0777, true);
        $new_filename = $filepath . '/'.$size_type.'/' . $new_filename;
        file_put_contents ($new_filename, $image); // works, or:

        return true;
    }

    //Функция удаления директории и картинок
    private static function RemoveDir($dir) {
        $files = array_diff(scandir($dir), ['.','..']);
        foreach ($files as $file) {
            (is_dir($dir.'/'.$file)) ? self::RemoveDir($dir.'/'.$file) : unlink($dir.'/'.$file);
        }
        return rmdir($dir);
    }
}