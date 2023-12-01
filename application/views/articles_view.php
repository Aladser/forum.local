<section class='w-50 mx-auto'>
    <a href="/article/create">
        <p class='d-inline-block border border-secondary text-decoration-none text-dark p-3'>Новая тема</p>
    </a>

    <section>
         <article class='d-flex border-start border-end border-secondary p-1'>
            <p class='w-25 m-0 fw-bolder p-1'>Название</p>
            <p class='w-75 text-center m-0 fw-bolder p-1'>Описание</p>
            <p class='w-25 text-center m-0 fw-bolder p-1'>Автор</p>
        </article>
        <?php foreach ($data['articles'] as $article) { ?>
            <a href="<?php echo '/article/show/'.$article['id']; ?>" class='text-decoration-none text-dark'>
            <!-- для удобства показываю автора статьи -->
            <article class='table-articles__tr cursor-pointer d-flex py-1 border-top border-start border-end border-secondary'>
                <p class='w-25 m-0 p-2'><?php echo $article['title']; ?></p>
                <p class='w-50 text-center m-0 p-2'><?php echo $article['summary']; ?></p>
                <p class='w-25 text-center m-0 p-2'><?php echo $article['login']; ?></p>
            </article>
            </a>
        <?php }?>
    </section>
</section>