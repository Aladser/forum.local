<div class='container text-center'>
    <h3 class='mb-4 theme-grey-color'>Регистрация нового пользователя</h3>

    <form class='form mx-auto mb-3' method="POST" action="/user/store">
        <input type="hidden" name="CSRF" value=<?php echo $CSRF; ?>>

        <input type="login" name='login' value="<?php echo $data['user']; ?>" 
        class="theme-border w-100 mb-3" placeholder="Логин" required>

        <input type="password" name='password'
        class="theme-border w-100 mb-3" placeholder="Пароль (минимум 3 символа)" required>

        <input type="password" name='password_confirm'
        class="theme-border w-100 mb-3" placeholder="Подтвердите пароль" required>

        <input type="submit" value="Отправить" class='button-theme-color border-0 button-basic button-wide mb-2'>
        <a href="/" class='button-theme-color button-basic button-wide'>Назад</a>  
    </form>

    <?php if (isset($data['error'])) {?>
    <p class='mx-auto fw-bolder theme-red-color'><?php echo $data['error']; ?></p> 
    <?php }?>  
</div>
