<container>
    <!-- кнопки -->
    <section class='w-50 mx-auto p-2'>
        <?php if ($data['login'] === $data['article']['username']) { ?>
            <a href="<?php echo '/article/edit/'.$data['article']['id']; ?>" 
               id='btn-edit' 
               class='d-inline-block text-decoration-none p-3 border-lime bg-lime text-white'>Редактировать</a>
            <a href="<?php echo '/article/remove/'.$data['article']['id']; ?>" 
               id='btn-edit' 
               class='d-inline-block text-decoration-none text-dark p-3 border-lime bg-lime text-white'>Удалить</a>
        <?php } ?>
        <a href="/article" class='d-inline-block text-decoration-none text-dark p-3 border-lime bg-lime text-white'>Назад</a>
    </section>

    <!-- статья --> 
    <section class='w-50 mx-auto p-2 text-center border-start-lime border-end-lime'>
        <h2><?php echo $data['article']['title']; ?></h2>
        <p>Автор: <?php echo $data['article']['username']; ?></p>
        <p><?php echo nl2br($data['article']['content']); ?></p>
    </section>

    <div class='w-50 mx-auto '><hr></div>

    <!-- комментарии -->
    <section class='w-50 mx-auto p-2 text-center border-start-lime border-end-lime'>
        <h4 class='text-start ps-2'> Комментарии </h4>
        <section id='comment-list'>
            <?php foreach ($data['comments'] as $comment) { ?>
                <article class='comment-list__item mb-2 border-C4C4C4' id='<?php echo "id-{$comment['id']}"; ?>'>
                    <p class='text-start m-0 ps-2 fw-bolder'><?php echo $comment['login']; ?></p>
                    <p class='text-start m-0 py-2 ps-3 fs-5'><?php echo nl2br($comment['content']); ?></p>
                    <p class='text-end m-0 pe-2'>
                        <?php if ($data['login'] === $comment['login']) { ?>
                            <button class='comment-list__btn-remove border-0 me-1' title='Удалить'>🗑</button>
                        <?php }?>
                        <?php echo $comment['time']; ?></p>
                </article>
            <?php } ?>
        </section>
        <div class='input-group pb-2'>
            <form method='post' class='d-flex justify-content-between w-100' id='form-send-message'>
                <input type="hidden" name="article" value="<?php echo $data['article']['id']; ?>" >
                <input type="hidden" name="author" value="<?php echo $data['login']; ?>" >
                <textarea class="input-group-prepend form-control border-lime" rows='3' placeholder='Сообщение' name='message' id='form-send-message__msg' required></textarea>
                <button type="submit" class='btn border-lime bg-lime text-white' title='Отправить'>Отправить</button>
            </form>
        </div>
    </section>

    <!-- ошибки -->
    <p id='prg-error' class='pb-4 text-center text-danger fw-bolder'></p>
</container>

<script type='text/javascript' src="http://forum.local/application/js/ServerRequest.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/DBLocalTime.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/article/ArticleClientController.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/CommentClientController.js"></script>