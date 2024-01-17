<container>
    <div class='content-width'>
        <section class='ps-2'>
        <a href=<?php echo $routes['article_create']; ?> class='ref mb-2'>Новая тема</a>
        </section>

        <section>
            <article class='d-flex theme-border-start theme-border-end p-1'>
                <p class='w-25 m-0 fw-bolder p-1 text-secondary'>Название</p>
                <p class='w-50 text-center m-0 fw-bolder p-1 text-secondary'>Описание</p>
                <p class='w-25 text-center m-0 fw-bolder p-1 text-secondary'>Автор</p>
            </article>
            <?php foreach ($data['articles'] as $article) { ?>
                <a href=<?php echo $routes['article_show'].'/'.$article['id']; ?> class='text-dark'>
                    <!-- для удобства показываю автора статьи -->
                    <article class='table-articles__tr cursor-pointer d-flex py-1 theme-border-top theme-border-start theme-border-end'>
                        <p class='w-25 m-0 p-2'><?php echo $article['title']; ?></p>
                        <p class='w-50 text-center m-0 p-2'><?php echo $article['summary']; ?></p>
                        <p class='w-25 text-center m-0 p-2'><?php echo $article['author']; ?></p>
                    </article>
                </a>
            <?php }?>
        </section>
        
        <!-- страницы показа статей (по 10) -->
        <?php if ($data['page-count'] > 1) {?>
            <section class='p-2 fs-5 mt-1'>
                <?php for ($i = 0; $i < $data['page-count']; ++$i) {?>
                    <?php
                    $page_number = $i + 1;
                    $class_css = 'theme-bg-сolor text-white py-2 px-4 rounded me-1';
                    if ($data['page-index'] + 1 === $page_number) {
                        $class_css .= ' theme-font-weight-bold';
                    }
                    ?>
                    <a class="<?php echo $class_css; ?>" href='<?php echo $routes['article'].'?list='.$page_number; ?>'> <?php echo $page_number; ?> </a>  
                <?php } ?>
            </section>
        <?php } ?>
    </div>
</container>