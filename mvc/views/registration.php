<div class="reg_wrap">
    <div class="reg_title">Регистрация</div>
    <form class="reg_form" method="post" action="/registration/registrate">
        <input class="reg_input" type="text" placeholder="Имя*" name="name">
        <input class="reg_input" type="text" placeholder="E-mail*" name="email">
        <input class="reg_input" type="password" placeholder="Пароль*" name="pass">
        <button type="submit">Зарегистрировать</button>
    </form>
    <div class="error_wrap">
        <ul>
            <?foreach ($data['params']['errors']['reg_errors'] as $error){?>
                <li><?=$error?></li>
            <?}?>
        </ul>
    </div>
</div>