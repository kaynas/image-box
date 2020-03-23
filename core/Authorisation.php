<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 18.03.2020
 * Time: 12:07
 */

namespace Core;


class Authorisation
{
    public static $user;

    //Если сессионная переменная пуста, значит поьзователь не зарегистрирован
    function __construct(){
        session_start();
        if(!$_SESSION['user_id']){
            self::$user = ['user_name' => 'User', 'user_id' => ''];
        }else{
            self::$user = ['user_name' => $_SESSION['user_name'], 'user_id' => $_SESSION['user_id']];
        }
    }

    //Проверяем строку на наличие некорректных символов
    protected function ValidateString($str){
        if(preg_match('/[А-ЯЁа-яё <>.,+*:;\']+/u', $str)){
            return false;
        }else{
            return true;
        }
    }

    //Проверям e-mail
    protected function ValidateEmail($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {//проверяем email на корректность
            return false;
        }else{
            return true;
        }
    }

    //Выход пользователя
    public function Logout(){
        self::$user['user_name'] = 'User';
        $_SESSION['user_name'] = 'User';

        self::$user['user_id'] = '';
        $_SESSION['user_id'] = '';
    }

    //Вход пользователя
    public function Login($email, $pass){
        $errors = [];

        //Проверяем email и пароль на наличие некорректных символов
        if(!$this->ValidateEmail($email)){
            $errors[] = 'Email has illegal symbols!';
        }
        if(!$this->ValidateString($pass)){
            $errors[] = 'Password has illegal symbols!';
        }

        //Проверяем введённую почту
        //Проверяем хеш пароля
        if(empty($errors)){
            $query_result = App::$db->query('SELECT * FROM users WHERE email = "'.$email.'";');
            $query_result = $query_result->fetch(\PDO::FETCH_ASSOC);

            if($query_result['pass_hash']){
                if(password_verify($pass, $query_result['pass_hash'])){
                    self::$user['user_name'] = $query_result['name'];
                    $_SESSION['user_name'] = $query_result['name'];

                    self::$user['user_id'] = $query_result['id'];
                    $_SESSION['user_id'] = $query_result['id'];
                }else{
                    $errors[] = 'Wrong Password!';
                }
            }else{
                $errors[] = 'Wrong Email!';
            }
        }

        return $errors;
    }

    public function Registrate(){

        $errors = [];

        if(!$this->ValidateString($_POST['name'])){
            $errors[] = 'Name has illegal symbols!';
        }
        if(!$this->ValidateEmail($_POST['email'])){
            $errors[] = 'Email has illegal symbols!';
        }
        if(!$this->ValidateString($_POST['pass'])){
            $errors[] = 'Password has illegal symbols!';
        }

        if(empty($errors)){
            //Проверяем, есть ли в базе такой пользователь
            $query_result = App::$db->query('SELECT * FROM users WHERE name = "'.$_POST['name'].'" OR email = "'.$_POST['email'].'";');
            $query_result = $query_result->fetch(\PDO::FETCH_ASSOC);
            if($query_result['id']){
                $errors[] = 'User with such name or email is already exist!';
            }
        }

        //Регистрируем пользователя
        if(empty($errors)){
            $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

            $insert_user_query = '                                              
                INSERT INTO users (name, email, pass_hash)          
                VALUES (?,?,?);
            ';
            $statement = App::$db->prepare($insert_user_query);
            $statement->execute([$_POST['name'], $_POST['email'], $pass]);

            $this->Login($_POST['email'], $_POST['pass']);
            mkdir('upload/'.$_POST['name']);
        }

        unset($_POST['name']);
        unset($_POST['email']);
        unset($_POST['pass']);

        return $errors;
    }

    //Проверяем, есть ли у пользователя права для доступа к данной странице
    public function Access($controller_name){
        $access_array = ['registration' => 'unreg', 'profile' => 'reg', 'edit' => 'reg'];
        $access = true;
        $user_type = 'unreg';

        if(self::$user['user_id']){
            $user_type = 'reg';
        }

        if(array_key_exists($controller_name, $access_array)){
            $access = ($access_array[$controller_name] == $user_type) ? true : false;
        }

        return $access;
    }
}

