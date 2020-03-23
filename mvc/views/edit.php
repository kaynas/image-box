<div class="edit_wrap">
    <div class="img_wrap">
        <img src="/<?=$data['content']['pic_address']?>/big/<?=$data['content']['pic_name']?>">
    </div>
    <div class="edit_info_wrap">
        <form class="fields_wrap" action="/edit/update/<?=$data['content']['pic_id']?>" method="post">
            <b>Добавить тег</b>
            <input type="text" placeholder="tag" name="tag">
            <b>Редактировать описание</b>
            <textarea name="comment">
                <?=$data['content']['comment']?>
            </textarea>
            <b>Выберите тег для удаления</b>
            <ul>
                <?foreach ($data['content']['tags'] as $key => $value){?>
                <li class="tag_wrap">
                    <input type="checkbox" name="delete_tags[]" value="<?=$key?>">
                    <div class="tag"><?=$value?></div>
                </li>
                <?}?>

            </ul>
            <button type="submit">Изменить</button>
        </form>
    </div>
</div>