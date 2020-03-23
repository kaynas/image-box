<?php
include_once 'config.php';
try {                                                               //проверяем наличие БД, если её нет, то создаём
    $dbh = new PDO("mysql:host=".HOST."", USER, PASS);
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    $dbh->query("
        CREATE DATABASE IF NOT EXISTS ".DB.";
    ");
} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}

$dbh = new PDO(DSN, USER, PASS);                                    //подключаемся к созданной БД
$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

try {                                                               //создаем таблицы(если их нет)
    $dbh->query("
        CREATE TABLE IF NOT EXISTS `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `name` varchar(100) NOT NULL,
            `email` varchar(100) NOT NULL,
            `pass_hash` varchar(100) NOT NULL
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    ");
} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}

try {
    $dbh->query("
        CREATE TABLE IF NOT EXISTS `pictures` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `pic_real_name` varchar(100) NOT NULL,
            `pic_address` varchar(100) NOT NULL,
            `title` mediumtext,
            `date` date NOT NULL,
            `view_count` int(11)
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    ");
} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}

try {
    $dbh->query("
        CREATE TABLE IF NOT EXISTS `comments` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `pic_id` int(11) NOT NULL,
            `comment` mediumtext NOT NULL,
            `date` date NOT NULL
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    ");
} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}

try {
    $dbh->query("
        CREATE TABLE IF NOT EXISTS `tags` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `pic_id` int(11) NOT NULL,
            `tag` varchar(100) NOT NULL
        )ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
    ");
} catch (PDOException $e) {
    die("DB ERROR: ". $e->getMessage());
}

mkdir('../upload');                                            //Создаем папку для картинок