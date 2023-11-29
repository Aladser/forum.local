<div class='w-50 mx-auto'>
    <a href="/article/create">
        <p class='d-inline-block border border-dark text-decoration-none text-dark p-3'>Новая тема</p>
    </a>

    <table class='table-articles table' id='table-articles'>
        <thead>
            <tr> 
                <th class='w-25'>Тема</th> 
                <th class='w-75 text-center'>Описание</th>
            </tr>
        <thead>
        <tbody>
        <?php foreach ($data['articles'] as $article) { ?>
            <tr class='table-articles__tr' id="<?php echo $article['id']; ?>">
                <td class='w-25'><?php echo $article['title']; ?></td>
                <td class='w-75 text-center'><?php echo $article['summary']; ?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>