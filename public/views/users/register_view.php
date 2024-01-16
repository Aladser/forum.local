<div class='container text-center'>
    <h3 class='mb-4 theme-grey-color'>Регистрация нового пользователя</h3>

    <form class='form mx-auto mb-3' method="POST" action=<?php echo $routes['store']; ?>>
        <input type="hidden" name="CSRF" value=<?php echo $data['csrf']; ?>>

        <input type="login" name='login' value="<?php echo $data['user']; ?>" 
        class="form-font theme-border w-100 mb-3 p-3" placeholder="Логин" required>

        <input type="password" name='password'
        class="form-font theme-border w-100 mb-3 p-3" placeholder="Пароль (минимум 3 символа)" required>

        <input type="password" name='password_confirm'
        class="form-font theme-border w-100 mb-3 p-3" placeholder="Подтвердите пароль" required>

        <input type="submit" value="Регистрация" class='border-0 ref-color mb-2'>
        <a href=<?php echo $routes['home']; ?> class='ref-color'>Назад</a>  
    </form>

    <?php if (isset($data['error'])) {?>
    <p class='mx-auto fw-bolder text-danger'><?php echo $data['error']; ?></p> 
    <?php }?>  
</div>
