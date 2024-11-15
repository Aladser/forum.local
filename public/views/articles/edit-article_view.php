<container>
    <div class='content-width'>
        <form method='POST' action="/article/update/<?php echo $data['article']->id; ?>">
            <input type="hidden" name='CSRF' value=<?php echo $CSRF; ?>>
            <input type="text" name="title" value=<?php echo $data['article']->title; ?> class='d-block ps-3 p-2 mb-2 w-100 theme-border' placeholder='Заголовок' required>
            <textarea name='summary' class="input-group-prepend form-control mb-2 w-100 theme-border" rows='2' placeholder='Краткое содержание' ><?php echo $data['article']->summary; ?></textarea>
            <textarea name='content' class="input-group-prepend form-control mb-2 w-100 theme-border" rows='10' placeholder='Содержание' required><?php echo $data['article']->content; ?></textarea>
            <input type="submit" value='Сохранить' class='button-theme-color button-basic button-wide mb-2'>
            <a href="/article/show/<?php echo $data['article']->id; ?>" class='button-theme-color button-basic button-wide'>Назад</a>
        </form>
        <p id='prg-error' class='pb-4 text-center text-danger fw-bolder'><?php echo $data['error']; ?></p>
    </div>
</container>