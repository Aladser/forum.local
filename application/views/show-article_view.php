<container>
    <!-- кнопки -->
    <section class='w-50 mx-auto p-2'>
        <?php if ($data['login'] === $data['article']['username']) { ?>
            <a href="<?php echo '/article/edit/'.$data['article']['id']; ?>" 
               id='btn-edit' 
               class='d-inline-block border border-dark text-decoration-none text-dark p-3 bg-white'>Редактировать</a>
            <a href="<?php echo '/article/remove/'.$data['article']['id']; ?>" 
               id='btn-edit' 
               class='d-inline-block border border-dark text-decoration-none text-dark p-3 bg-white'>Удалить</a>
        <?php } ?>
        <a href="/article" class='d-inline-block border border-dark text-decoration-none text-dark p-3 bg-white'>Назад</a>
    </section>

    <!-- статья --> 
    <section class='w-50 mx-auto p-2 text-center border-start border-end'>
        <h2><?php echo $data['article']['title']; ?></h2>
        <p>Автор: <?php echo $data['article']['username']; ?></p>
        <p><?php echo $data['article']['content']; ?></p>
    </section>

    <!-- комментарии -->
    <div class='w-50 mx-auto'><hr></div>
    <section class='w-50 mx-auto p-2 text-center border-start border-end'>
        <h4 class='text-start ps-2'> Комментарии </h4>
        <section id='comment-list'>
            <?php foreach ($data['comments'] as $comment) { ?>
                <article class='border-C4C4C4 mb-2'>
                    <p class='text-start m-0 ps-2 fw-bolder'><?php echo $comment['login']; ?></p>
                    <p class='text-start m-0 py-2 ps-3 fs-5'><?php echo $comment['content']; ?></p>
                    <p class='text-end m-0 pe-2'><?php echo $comment['time']; ?></p>
                </article>
            <?php } ?>
        </section>
        <div class='input-group pb-2'>
            <form method='post' class='d-flex justify-content-between w-100' id='form-send-message'>
                <input type="hidden" name="article" value="<?php echo $data['article']['id']; ?>" >
                <input type="hidden" name="author" value="<?php echo $data['login']; ?>" >
                <textarea class="input-group-prepend form-control" rows='3' placeholder='Сообщение' name='message' required></textarea>
                <button type="submit" class='btn border border-black' title='Отправить'>Отправить</button>
            </form>
        </div>
    </section>

    <!-- ошибки -->
    <p id='table-error' class='pb-4 text-center text-danger fw-bolder'></p>
</container>

<script type='text/javascript' src="http://forum.local/application/js/ServerRequest.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/DBLocalTime.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/article/ArticleClientController.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/CommentClientController.js"></script>