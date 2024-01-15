<div class='container text-center'>
    <h3 class='mt-4 mb-4 text-secondary'>Регистрация нового пользователя</h3>

    <form class='form mx-auto' method="POST" action=<?=$routes['store'];?>>
        <input type="hidden" name="CSRF" value=<?= $data['csrf']; ?>>

        <input type="login" class="form-font theme-border w-100 mb-3 p-2" 
        id="reg-form__email-input" name='login' value="<?= $data['user']; ?>" placeholder="логин" required>


        <input type="password" class="form-font theme-border w-100 mb-3 p-2" 
        id="reg-form__password1-input" name='password' placeholder="пароль (минимум 3 символа)" required>

        <input type="password" class="form-font theme-border w-100 mb-3 p-2" 
        id="reg-form__password2-input" name='password_confirm' placeholder="подтвердите пароль" required>

        <input type="submit" class='ref-color form-font border-0 p-3 mb-2 w-100' value="Регистрация" id='reg-form__reg-btn'>
        <a href=<?=$routes['home'];?> class='text-decoration-none'>
            <div class='ref-color form-font mx-auto p-3 w-100'>Назад</div>
        </a>

        <p class='mx-auto fw-bolder text-danger p-2'><?= $data['error']; ?></p>     
    </form>
</div>
