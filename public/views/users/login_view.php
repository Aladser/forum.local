<div class='container text-center'>
    <h3 class='mt-4 mb-4 text-secondary'>Войти</h3>

    <form class='form mx-auto' method="POST" action=<?php echo $routes['auth']; ?>>
        <input type="hidden" name='CSRF' value=<?php echo $data['csrf']; ?>>

        <input type="text" name='login' value="<?php echo $data['user']; ?>" 
        class="form-font theme-border w-100 p-3 mb-3" placeholder="Логин" required>

        <input type="password" name='password' 
        class="form-font theme-border w-100 p-3 mb-3" placeholder="Пароль" required>

        <input type="submit" value="Войти" class='border-0 form-font ref-color w-100 p-3 mb-2 ' >
        
        <a href=<?php echo $routes['home']; ?> class='text-decoration-none'>
            <div class='form-font ref-color w-100 p-3 mx-auto'>Назад</div>
        </a>
    </form>

    <?php if (isset($data['error'])) {?>
    <p class='fw-bolder text-danger w-50 pt-2 mx-auto mb-0'><?php echo $data['error']; ?></p>
    <?php }?>
</div>