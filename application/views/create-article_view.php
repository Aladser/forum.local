<section class='w-50 mx-auto text-center'>
    <form method='POST' id='form-create-article'>
        <input type="hidden" name='CSRF' value=<?php echo $data['csrf']; ?>>
        <input type="text" class='d-block mx-auto ps-3 p-2 mb-2 w-75 text-secondary border-lime' 
        name="title" placeholder='Заголовок' required>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto text-secondary border-lime" 
        name='summary' rows='2'placeholder='Краткое содержание'></textarea>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto text-secondary border-lime" 
        name='content' rows='10' placeholder='Содержание' required></textarea>
        <input type="submit" value='Добавить' class='d-inline-block text-decoration-none p-2 border-lime bg-lime text-white'>
        <a href="/article">
            <p class='d-inline-block p-2 text-decoration-none border-lime bg-lime text-white'>Назад</p>
        </a>
    </form>
    <p id='prg-error' class='pb-4 text-center text-danger fw-bolder'></p>
</section>

<script type='text/javascript' src="http://forum.local/application/js/ServerRequest.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/article/ArticleClientController.js"></script>
