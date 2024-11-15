<container class="text-center">
    <form method="POST" action="/article/remove/<?php echo $data['article']->id; ?>" class="mx-auto w-75 p-4">
        <input type="hidden" name='CSRF' value=<?php echo $CSRF; ?>>
        <p class="fs-5">Вы действительно хотите удалить запись?</p>
        <div class="d-flex justify-content-center w-100 mx-auto">
            <input type="submit" value="Да" class="button-basic button-theme-color rounded">
            <a href="/article/show/<?php echo $data['article']->id; ?>" class="button-basic button-theme-color rounded">Нет</a>
        </div>
    </form>
</container>
