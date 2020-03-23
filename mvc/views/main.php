<div class="gallery_wrap">
    <div class="main_images_wrap">
        <div><b>New pictures</b></div>
        <div class="gallery_images_wrap">
            <?foreach ($data['content']['new_pic'] as $image){?>
                <div class="image">
                    <a href="/image/index/<?=$image['id']?>">
                        <img src="/<?=$image['pic_address']?>/small/<?=$image['filename']?>">
                    </a>
                    <div class="gallery_item_info_wrap">
                        <div>Дата: <b><?=$image['date']?></b></div>
                        <div>Пользователь: <b><?=$image['name']?></b></div>
                        <div>Кол-во просмотров: <b><?=$image['view_count']?></b></div>
                    </div>
                </div>
            <?}?>
        </div>
        <div><b>Most popular</b></div>
        <div class="gallery_images_wrap">
            <?foreach ($data['content']['popular_pic'] as $image){?>
                <div class="image">
                    <a href="/image/index/<?=$image['id']?>">
                        <img src="/<?=$image['pic_address']?>/small/<?=$image['filename']?>">
                    </a>
                    <div class="gallery_item_info_wrap">
                        <div>Дата: <b><?=$image['date']?></b></div>
                        <div>Пользователь: <b><?=$image['name']?></b></div>
                        <div>Кол-во просмотров: <b><?=$image['view_count']?></b></div>
                    </div>
                </div>
            <?}?>
        </div>
        <div><b>Random pictures</b></div>
        <div class="gallery_images_wrap">
            <?foreach ($data['content']['random_pic'] as $image){?>
                <div class="image">
                    <a href="/image/index/<?=$image['id']?>">
                        <img src="/<?=$image['pic_address']?>/small/<?=$image['filename']?>">
                    </a>
                    <div class="gallery_item_info_wrap">
                        <div>Дата: <b><?=$image['date']?></b></div>
                        <div>Пользователь: <b><?=$image['name']?></b></div>
                        <div>Кол-во просмотров: <b><?=$image['view_count']?></b></div>
                    </div>
                </div>
            <?}?>
        </div>
    </div>
    <div class="gallery_filters_wrap">
        <b>Поиск</b>
        <form action="/gallery" method="post">
            <input type="text" name="tag" placeholder="Тег">
            <input type="text" name="user_name" placeholder="Имя пользователя">
            <button type="submit">Найти</button>
        </form>
        <div class="info_list">
            <p><b>Популярные теги</b></p>
            <ul>
                <?foreach ($data['content']['tags'] as $tag){?>
                    <li>
                        <a class="popular_tag">
                            <div class="tag_name"><?=$tag['tag']?></div>
                            <div class="tag_vews_count"><?=$tag['count']?></div>
                        </a>
                    </li>
                <?}?>
            </ul>
            <p><b>Популярные пользователи</b></p>
            <ul>
                <?foreach ($data['content']['users'] as $user){?>
                    <li>
                        <a class="popular_tag">
                            <div class="tag_name"><?=$user['user_name']?></div>
                            <div class="tag_vews_count"><?=$user['count']?></div>
                        </a>
                    </li>
                <?}?>
            </ul>
            <p>
                Цифра отображает кол-во просмотров всех фото по данному теги или суммарное кол-во просмотров
                фотографий соответствующего пользователя
            </p>
        </div>
    </div>
</div>