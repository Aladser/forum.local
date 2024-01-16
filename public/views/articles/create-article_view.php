<section class='w-50 mx-auto text-center'>
    <form method='POST' id='form-create-article' action=<?php echo $routes['article_store']; ?>>
        <input type="hidden" name='CSRF' value=<?php echo $data['csrf']; ?>>
        <input type="text" class='d-block mx-auto ps-3 p-2 mb-2 w-75 text-secondary theme-border' 
        name="title" placeholder='Заголовок' value='<?php echo $data['title']; ?>' required>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto text-secondary theme-border" 
        name='summary' rows='2'placeholder='Краткое содержание'></textarea>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto text-secondary theme-border" 
        name='content' rows='10' placeholder='Содержание' required></textarea>
        <input type="submit" value='Добавить' class='d-inline-block text-decoration-none p-2 theme-border ref-color'>
        <a href=<?php echo $routes['home']; ?>>
            <p class='d-inline-block p-2 text-decoration-none theme-border ref-color'>Назад</p>
        </a>
    </form>
    <p id='prg-error' class='pb-4 text-center text-danger fw-bolder'><?php echo $data['error']; ?> </p>
</section>