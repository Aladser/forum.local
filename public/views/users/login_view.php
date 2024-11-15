<div class='container text-center'>
    <h3 class='mb-4 theme-grey-color'>Войти</h3>

    <form class='form mx-auto mb-3' method="POST" action="/user/auth">
        <input type="hidden" name='CSRF' value=<?php echo $CSRF; ?>>

        <input type="text" name='login' value="<?php echo $data['user']; ?>" placeholder="Логин" required>
        <input type="password" name='password' placeholder="Пароль" required>

        <input type="submit" value="Войти" class='button-theme-color border-0 button-basic button-wide mb-2'>
        <a href="/"  class='button-theme-color button-basic button-wide'>Назад</a>
    </form>

    <?php if (isset($data['error'])) {?>
    <p class='fw-bolder w-50 mx-auto theme-red-color'><?php echo $data['error']; ?></p>
    <?php }?>
</div>
