<div class='w-75 mx-auto'>
    <table class='table'>
        <thead>
            <tr> 
                <th>Тема</th> 
                <th>Автор</th>
                <th>Описание</th>
                <th>Создана</th>  
            </tr>
        <thead>
        <tbody>
        <?php foreach ($data['articles'] as $article) { ?>
            <tr id="<?php echo $article['id']; ?>">
                <td><?php echo $article['title']; ?></td>
                <td><?php echo $article['author_id']; ?></td>
                <td><?php echo $article['summary']; ?></td>
                <td><?php echo mb_substr($article['time'], 0, 10); ?></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</div>