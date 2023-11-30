<section class='w-50 mx-auto'>
    <a href="/article/create">
        <p class='d-inline-block border border-dark text-decoration-none text-dark p-3'>Новая тема</p>
    </a>
    <a href="/article/" id='btn-about' class='d-none'>
        <p class='d-inline-block border border-dark text-decoration-none text-dark p-3 bg-white'>Подробно</p>
    </a>
    <a href="" id='btn-edit' class='d-none'>
        <p class='d-inline-block border border-dark text-decoration-none text-dark p-3 bg-white'>Редактировать</p>
    </a>
    <button class='d-inline-block border border-dark text-decoration-none text-dark p-3 bg-white d-none' id='btn-remove'>Удалить</button>

    <table class='table-articles table' id='table-articles'>
        <thead>
            <tr> 
                <th class='w-25'>Название</th> 
                <th class='w-75 text-center'>Описание</th>
            </tr>
        <thead>
        <tbody>
        <?php foreach ($data['articles'] as $article) { ?>
            <tr class='table-articles__tr cursor-pointer' id="<?php echo 'id-'.$article['id']; ?>">
                <td class='w-25'><?php echo $article['title']; ?></td>
                <td class='w-75 text-center'><?php echo $article['summary']; ?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
    <p id='table-error' class='pb-4 text-center text-danger fw-bolder'></p>
</section>

<script type='text/javascript' src="http://forum.local/application/js/ServerRequest.js"></script>
<script type='text/javascript' src="http://forum.local/application/js/ArticleClientController.js"></script>