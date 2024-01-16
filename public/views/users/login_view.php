<div class='container text-center'>
    <h3 class='mb-4 theme-grey-color'>Войти</h3>

    <form class='form mx-auto mb-3' method="POST" action=<?php echo $routes['auth']; ?>>
        <input type="hidden" name='CSRF' value=<?php echo $data['csrf']; ?>>

        <input type="text" name='login' value="<?php echo $data['user']; ?>" 
        class="theme-border w-100 mb-3" placeholder="Логин" required>
        <input type="password" name='password' 
        class="theme-border w-100 mb-3" placeholder="Пароль" required>

        <input type="submit" value="Войти" class='ref-color border-0 mb-2'>
        <a href=<?php echo $routes['home']; ?>  class='ref-color'>Назад</a>
    </form>

    <?php if (isset($data['error'])) {?>
    <p class='fw-bolder text-danger w-50 mx-auto'><?php echo $data['error']; ?></p>
    <?php }?>
</div>
