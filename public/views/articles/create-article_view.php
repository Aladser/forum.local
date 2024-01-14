<section class='w-50 mx-auto text-center'>
    <form method='POST' id='form-create-article' action='/article/store'>
        <input type="hidden" name='CSRF' value=<?php echo $data['csrf']; ?>>
        <input type="text" class='d-block mx-auto ps-3 p-2 mb-2 w-75 text-secondary border-theme' 
        name="title" placeholder='Заголовок' value='<?php echo $data['title']; ?>' required>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto text-secondary border-theme" 
        name='summary' rows='2'placeholder='Краткое содержание'></textarea>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto text-secondary border-theme" 
        name='content' rows='10' placeholder='Содержание' required></textarea>
        <input type="submit" value='Добавить' class='d-inline-block text-decoration-none p-2 border-theme bg-theme text-white'>
        <a href="/article">
            <p class='d-inline-block p-2 text-decoration-none border-theme bg-theme text-white'>Назад</p>
        </a>
    </form>
    <p id='prg-error' class='pb-4 text-center text-danger fw-bolder'><?php echo $data['error']; ?> </p>
</section>