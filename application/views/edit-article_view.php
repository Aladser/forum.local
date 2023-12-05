<div class='w-50 mx-auto text-center'>
    <form method='POST' id='form-edit-article'>
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <input type="hidden" name="author" value="<?php echo $data['login']; ?>" >
        <input type="text" class='d-block mx-auto ps-3 p-2 mb-2 w-75 border-lime text-secondary' name="title" placeholder='Заголовок' value="<?php echo $data['title']; ?>" required>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto border-lime text-secondary" rows='2'placeholder='Краткое содержание' name='summary' required> <?php echo $data['summary']; ?></textarea>
        <textarea class="input-group-prepend form-control mb-2 w-75 mx-auto border-lime text-secondary" rows='10'placeholder='Содержание' name='content' required><?php echo $data['content']; ?></textarea>
        <input type="submit" value='Сохранить' class='d-inline-block text-decoration-none p-2 border-lime bg-lime text-white'>
        <a href="<?php echo '/article/show/'.$data['id']; ?>">
            <p class='d-inline-block text-decoration-none p-2 border-lime bg-lime text-white'>Назад</p>
        </a>
    </form>
    <p id='prg-error' class='pb-4 text-center text-danger fw-bolder'></p>
</div>

<script type='text/javascript' src="http://forum.local/application/js/ServerRequest.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/article/ArticleClientController.js"></script>