<section class='w-50 mx-auto'>
    <a href="/article/create">
        <p class='d-inline-block text-decoration-none p-3 rounded bg-lime text-white'>Новая тема</p>
    </a>

    <section class='mt-1'>
         <article class='d-flex border-start-lime border-end-lime p-1'>
            <p class='w-25 m-0 fw-bolder p-1 text-secondary'>Название</p>
            <p class='w-50 text-center m-0 fw-bolder p-1 text-secondary'>Описание</p>
            <p class='w-25 text-center m-0 fw-bolder p-1 text-secondary'>Автор</p>
        </article>
        <?php foreach ($data['articles'] as $article) { ?>
            <a href="<?php echo '/article/show/'.$article['id']; ?>" class='text-decoration-none text-dark'>
                <!-- для удобства показываю автора статьи -->
                <article class='table-articles__tr cursor-pointer d-flex py-1 border-top-lime border-start-lime border-end-lime'>
                    <p class='w-25 m-0 p-2'><?php echo $article['title']; ?></p>
                    <p class='w-50 text-center m-0 p-2'><?php echo $article['summary']; ?></p>
                    <p class='w-25 text-center m-0 p-2'><?php echo $article['author']; ?></p>
                </article>
            </a>
        <?php }?>
    </section>
    <!-- страницы показа статей (по 5) -->
    <?php if ($data['page-count'] > 1) {?>
        <section class='p-2 fs-5 mt-1'>
            <?php for ($i = 0; $i < $data['page-count']; ++$i) {?>
                <?php $page_number = $i + 1; ?>
                <a class='bg-lime text-decoration-none py-2 px-4 text-white rounded' href='<?php echo '/article?list='.$page_number; ?>'><?php echo $page_number; ?></a>
            <?php } ?>
        </section>
    <?php } ?>
</section>