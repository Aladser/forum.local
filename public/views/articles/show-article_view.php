<container>
    <div class='content-width'>
        <!-- кнопки -->
        <section class='mb-3'>
            <?php if ($authuser == $data['article']->author) { ?>
                <a href="/article/edit/<?php echo $data['article']->id; ?>" class='button-small button-theme-color rounded'>Редактировать</a>
                <a href="/article/remove-confirm/<?php echo $data['article']->id; ?>" class='button-small button-theme-color rounded'>Удалить</a>
            <?php } ?>
        </section>

        <!-- статья --> 
        <section class='p-2 text-center theme-border-start theme-border-end'>
            <p>Автор: <?php echo $data['article']->author->login; ?></p>
            <p class='m-2 p-2 border-top border-bottom text-start'><?php echo nl2br($data['article']->content); ?></p>
        </section>

        <div><hr class='theme-border'></div>

        <!-- комментарии -->
        <section class='p-2 text-center theme-border-start theme-border-end'>
            <h4 class='text-start ps-2'> Комментарии </h4>
            <section id='comment-list'>
                <?php foreach ($data['article']->comments as $comment) { ?>
                    <article class='comment-list__item mb-2'>
                        <p class='text-start m-0 ps-2 fw-bolder'><?php echo $comment->author->login; ?></p>
                        <p class='text-start m-0 py-2 ps-3 fs-5'><?php echo nl2br($comment->content); ?></p>
                        <div class='text-end m-0 pe-2'>
                            <?php if ($authuser == $comment->author) { ?>
                                <form method="POST" action="<?php echo '/comment/remove/'.$comment->id; ?>" class="remove-comment-form d-inline-block">
                                    <input type="hidden" name='CSRF' value=<?php echo $CSRF; ?>>
                                    <input type='submit' class='comment-list__btn-remove border-0' title='Удалить' value='🗑'>
                                </form>
                            <?php }?>
                            <span><?php echo $comment->time; ?></span>
                        </div>
                    </article>
                <?php } ?>
            </section>
            <div class='input-group pb-2'>
                <form method='post' class='d-flex justify-content-between w-100' id='form-send-message'>
                    <input type="hidden" name='CSRF' value=<?php echo $CSRF; ?>>
                    <input type="hidden" name="article_id" value="<?php echo $data['article']->id; ?>" >
                    <textarea class="input-group-prepend form-control theme-border" rows='3' placeholder='Сообщение' name='content' id='form-send-message__msg' required></textarea>
                    <button type="submit" class='btn-send-msg button-theme-color ' title='Отправить'>Отправить</button>
                </form>
            </div>
        </section>

        <!-- ошибки -->
        <p id='prg-error' class='pb-4 text-center text-danger fw-bolder'></p>
    </div>
</container>
