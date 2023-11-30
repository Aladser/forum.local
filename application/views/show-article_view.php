<container>
    <section class='w-50 mx-auto p-2 text-center border-start border-end'>
        <a href="/article">
            <p class='d-inline-block border border-dark text-decoration-none text-dark p-2'>Назад</p>
        </a>
        <h2><?php echo $data['article']['title']; ?></h2>
        <p><?php echo $data['article']['content']; ?></p>
    </section>
    <div class='w-50 mx-auto'><hr></div>
    <section class='w-50 mx-auto p-2 text-center border-start border-end'>
        <h4 class='text-start ps-2'> Комментарии </h4>
        <p>
            <?php foreach ($data['comments'] as $comment) { ?>
                <article class='border-C4C4C4 mb-2'>
                    <p class='text-start m-0 ps-2 fw-bolder'><?php echo $comment['login']; ?></p>
                    <p class='text-start m-0 py-2 ps-3 fs-5'><?php echo $comment['content']; ?></p>
                    <p class='text-end m-0 pe-2'><?php echo $comment['time']; ?></p>
                </article>
            <?php } ?>
        </p>
        <div class='input-group pb-2'>
            <form method='post' class='d-flex justify-content-between w-100' id='form-send-message'>
                <input type="hidden" name="author" value="<?php echo $data['login']; ?>" >
                <textarea class="input-group-prepend form-control" rows='3' placeholder='Сообщение' name='message'></textarea>
                <button type="submit" class='btn border border-black' title='Отправить'>Отправить</button>
            </form>
        </div>
    </section>
    <p id='table-error' class='pb-4 text-center text-danger fw-bolder'></p>
</container>

<script type='text/javascript' src="http://forum.local/application/js/ServerRequest.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/ArticleClientController.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/CommentClientController.js"></script>