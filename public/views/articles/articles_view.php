<section class='ps-2 mb-3'>
    <a href="/article/create" class='button-theme-color button-small rounded mb-2'>Новая тема</a>
</section>

<section class='mb-1'>
    <article class='d-flex p-1 theme-border-start theme-border-end'>
        <p class='w-25 m-0 fw-bolder p-1 text-secondary'>Название</p>
        <p class='w-50 text-center m-0 fw-bolder p-1 text-secondary'>Описание</p>
        <p class='w-25 text-center m-0 fw-bolder p-1 text-secondary'>Автор</p>
    </article>
    <?php foreach ($data['articles'] as $article) { ?>
        <a href=<?php echo "article/show/$article->id"; ?> class='text-dark'>
            <article class='table-article-row'>
                <p class='w-25 m-0 p-2'><?php echo $article->title; ?></p>
                <p class='w-50 m-0 text-center p-2'><?php echo $article->summary; ?></p>
                <p class='w-25 m-0 text-center p-2'><?php echo $article->author->login; ?></p>
            </article>
        </a>
    <?php }?>
</section>

<!-- пагинация -->
<?php if ($data['page-count'] > 1) { ?>
    <section class='p-2 fs-5'>
        <?php for ($i = 1; $i <= $data['page-count']; ++$i) {?>
            <?php if ($data['page-index'] + 1 == $i) { ?>
                <a class="button-theme-color fw-bold py-2 px-4 rounded me-1" href="/article?list=<?php echo $i; ?>"> <?php echo $i; ?> </a> 
            <?php } else { ?>
                <a class="button-theme-color py-2 px-4 rounded me-1" href="/article?list=<?php echo $i; ?>"> <?php echo $i; ?> </a> 
            <?php } ?>
        <?php } ?>
    </section>
<?php }?>
