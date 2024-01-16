<section class='article-w mx-auto text-center'>
    <form method='POST' id='form-create-article' action=<?php echo $routes['article_store']; ?>>
        <input type="hidden" name='CSRF' value=<?php echo $data['csrf']; ?>>

        <input type="text" class='d-block mx-auto ps-3 p-2 mb-2 w-100 text-secondary theme-border' 
        name="title" placeholder='Заголовок' value='<?php echo $data['title']; ?>' required>

        <textarea class="input-group-prepend form-control mb-2 w-100 mx-auto text-secondary theme-border" 
        name='summary' rows='2'placeholder='Краткое содержание'></textarea>

        <textarea class="input-group-prepend form-control mb-2 w-100 mx-auto text-secondary theme-border" 
        name='content' rows='10' placeholder='Содержание' required></textarea>

        <input type="submit" value='Добавить' class='article__btn form-font ref-color p-2 mx-auto theme-border mb-1'>
        
        <a href=<?php echo $routes['home']; ?> class='text-decoration-none'>
            <p class='article__btn form-font ref-color p-2 mx-auto theme-border mb-1'>Назад</p>
        </a>
    </form>
    <p id='prg-error' class='pb-4 text-center text-danger fw-bolder'><?php echo $data['error']; ?> </p>
</section>