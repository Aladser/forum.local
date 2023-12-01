<div class='w-50 mx-auto text-center'>
    <form method='POST' id='form-create-article'>
        <input type="hidden" name="author" value="<?php echo $data['login']; ?>" >
        <input type="text" class='d-block mx-auto ps-3 p-2 mb-2 w-75 border-C4C4C4' name="title" placeholder='Заголовок' required>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto" rows='2'placeholder='Краткое содержание' name='summary' required></textarea>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto" rows='10'placeholder='Содержание' name='content' required></textarea>
        <input type="submit" value='Добавить' class='d-inline-block border border-dark text-decoration-none text-dark p-2 bg-white border-C4C4C4'>
        <a href="/article">
            <p class='d-inline-block border border-dark text-decoration-none text-dark p-2'>Назад</p>
        </a>
    </form>
    <p id='table-error' class='pb-4 text-center text-danger fw-bolder'></p>
</div>

<script type='text/javascript' src="http://forum.local/application/js/ServerRequest.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/ArticleClientController.js"></script>
