<div class='w-50 mx-auto'>
    <div id='block-buttons' class='pb-4'>
        <input type="button" value="Новая тема" class='btn border border-dark fs-5'>
    </div>

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