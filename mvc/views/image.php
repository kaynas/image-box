<div class="image_page_wrap">
    <div class="full_image_wrap">
        <img src="/<?=$data['content']['pic_address']?>/big/<?=$data['content']['filename']?>">
        <p><b>Подпись владельца: </b><?=$data['content']['title']?></p>
    </div>
    <div class="comments_wrap">
        <b><?=$data['notes']?></b>
        <p>Ваш комментарий</p>
        <form action="/image/comment/<?=$data['content']['id']?>" method="post">
            <textarea name="user_comment"></textarea>
            <button type="submit">Send</button>
        </form>
        <div class="comments_list">
            <p><b>Комментарии пользователей</b></p>
            <ul>
                <?foreach ($data['content']['comments'] as $comment){?>
                    <li>
                        <div class="popular_tag">
                            <div class="tag_name"><?=$comment['user_name']?></div>
                            <div class="tag_vews_count"><?=$comment['comment']?></div>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>
</div>