<div class='container text-center'>
    <h3 class='mt-4 mb-4 text-secondary'>Регистрация нового пользователя</h3>

    <form class='form mx-auto' method="POST" action=<?php echo $routes['store']; ?>>
        <input type="hidden" name="CSRF" value=<?php echo $data['csrf']; ?>>

        <input type="login" name='login' value="<?php echo $data['user']; ?>" id="reg-form__email-input" 
        class="form-font theme-border w-100 mb-3 p-3" placeholder="логин" required>

        <input type="password" name='password' id="reg-form__password1-input"
        class="form-font theme-border w-100 mb-3 p-3" placeholder="пароль (минимум 3 символа)" required>

        <input type="password" name='password_confirm' id="reg-form__password2-input" 
        class="form-font theme-border w-100 mb-3 p-3" placeholder="подтвердите пароль" required>

        <input type="submit" value="Регистрация" id='reg-form__reg-btn' 
        class='ref-color form-font border-0 p-3 mb-2 w-100'>
        
        <a href=<?php echo $routes['home']; ?> class='text-decoration-none'>
            <div class='ref-color form-font mx-auto p-3 w-100'>Назад</div>
        </a>

        <?php if (isset($data['error'])) {?>
        <p class='mx-auto fw-bolder text-danger p-2'><?php echo $data['error']; ?></p> 
        <?php }?>    
    </form>
</div>
