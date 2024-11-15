<container>
    <div class='content-width'>
        <form method='POST' id='form-create-article' action="/article/store">
            <input type="hidden" name='CSRF' value=<?php echo $CSRF; ?>>

            <input type="text" class='w-100 d-block ps-3 p-2 mb-2 text-secondary rounded theme-border' 
            name="title" placeholder='Заголовок' value='<?php echo $data['title']; ?>' required>

            <textarea class="w-100 input-group-prepend form-control mb-2 text-secondary rounded theme-border" 
            name='summary' rows='2'placeholder='Краткое содержание'></textarea>

            <textarea class="w-100 input-group-prepend form-control mb-2 text-secondary rounded theme-border" 
            name='content' rows='10' placeholder='Содержание' required></textarea>

            <input type="submit" value='Добавить' class='button-basic button-wide button-theme-color rounded mb-2'>
            <a href="/" class='button-basic button-wide button-theme-color rounded'>Назад</a>
        </form>
        <p id='prg-error' class='pb-4 text-center text-danger fw-bolder'><?php echo $data['error']; ?> </p>
    </div>
</container>