<form class="add_wrap" method="post" action="/profile/add" enctype="multipart/form-data">
    <input type="file" name="file_field[]" accept=".png, .jpg, .jpeg" multiple>
    <button type="submit">Добавить картинки</button>
</form>
<form class="profile_wrap" method="post" action="/profile/delete">
    <button type="submit">Удалить выбранные</button>

    <div class="images_wrap">
        <?foreach ($data['content'] as $image){?>
            <div class="image">
                <a href="/edit/index/<?=$image['id']?>">
                    <img src="/<?=$image['pic_address']?>/small/<?=$image['filename']?>">
                </a>
                <div class="item_info_wrap">
                    <div>
                        <input type="checkbox" name="checkbox[]" value="<?=$image['id']?>">
                    </div>
                    <div>
                        Дата: <b><?=$image['date']?></b>
                    </div>
                    <div>
                        Кол-во просмотров: <b><?=$image['view_count']?></b>
                    </div>
                </div>
            </div>
        <?}?>
    </div>
</form>