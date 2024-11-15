<container class="text-center">
    <form method="POST" action="/article/remove/<?php echo $data['article']->id; ?>" class="mx-auto w-50 p-4">
        <input type="hidden" name='CSRF' value=<?php echo $CSRF; ?>>
        <p class="fs-3 fw-bolder">Вы действительно хотите удалить запись?</p>
        <div class="d-flex w-75 mx-auto">
            <input type="submit" value="Да" class="button-basic button-theme-color">
            <a href="/article/show/<?php echo $data['article']->id; ?>" class="button-basic button-theme-color">Нет</a>
        </div>
    </form>
</container>
