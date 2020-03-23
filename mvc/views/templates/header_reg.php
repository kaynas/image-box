<!DOCTYPE html>
<html>
    <head>
        <title>Image Box</title>
        <meta charset="UTF-8">
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="/css/styles.css" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <div class="header_title"><h2>ImageBox</h2></div>
            <div class="login_fields_wrap">
                <div class="login_title">Приветствуем, <?=$data['params']['user_name']?>!</div>

            </div>
            <div class="reg_href">
                <a class="top_menu" href="/">Главная</a>
                <!--<a class="top_menu" href="/">Profile</a>-->
                <a class="top_menu" href="/profile">Профиль</a>
                <a class="top_menu" href="/gallery">Галерея</a>
                <a href="/<?=$data['params']['view_name']?>/logout">Выйти</a>
            </div>
        </div>

        <?php include_once './mvc/views/'.$content_view;?>

        <script src="/js/scripts.js"></script>
    </body>
</html>