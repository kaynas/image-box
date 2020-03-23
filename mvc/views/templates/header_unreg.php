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
                <div class="login_title">Приветствуем, User!</div>
                <form class="login_fields" method="post" action="/<?=$data['params']['view_name']?>/login">
                    <input type="text" name="email" placeholder="Email">
                    <input type="password" name="pass" placeholder="Password">
                    <button type="submit">Войти</button>
                </form>
            </div>
            <div class="reg_href">
                <a class="top_menu" href="/">Главная</a>
                <a class="top_menu" href="/gallery">Галерея</a>
                <a class="top_menu" href="/registration">Регистрация</a>
            </div>
        </div>
        <div class="login_errors">
            <ul>
                <?foreach ($data['params']['errors']['login_errors'] as $error){?>
                    <li><?=$error?></li>
                <?}?>
            </ul>
        </div>

        <?php include_once './mvc/views/'.$content_view;?>

        <script src="/js/scripts.js"></script>
    </body>
</html>