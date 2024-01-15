<div class='container text-center'>
    <h3 class='mt-4 mb-4 text-secondary'>Войти</h3>

    <form class='login-form mx-auto' method="POST" action=<?=$routes['auth'];?>>
        <input type="hidden" name='CSRF' value=<?php echo $data['csrf']; ?>>
        <input type="text" class="form-font theme-border p-3 w-100 mb-3" name='login' class="form__input w-100 mb-2 p-1 border-theme" placeholder="Логин" value="<?php echo $data['user']; ?>" required>
        <input type="password" class="form-font theme-border p-3 w-100 mb-3" name='password' class="form__input w-100 mb-2 p-1 border-theme" placeholder="Пароль"  required>
        <input type="submit" class='form-font ref-color border-0 p-3 mb-2 w-50' value="Войти">
        <a href=<?=$routes['home'];?> class='text-decoration-none'><div class='form-font ref-color mx-auto p-3 w-50'>Назад</div></a>
    </form>

    <?php if (isset($data['error'])) {?>
    <p class='w-50 mx-auto fw-bolder text-danger pt-2 mb-0'><?php echo $data['error']; ?></p>
    <?php }?>
</div>