<div class='container text-center'>
    <h3 class='mt-4 mb-4 text-secondary'>Регистрация нового пользователя</h3>

    <form class='reg-form' method="POST" action=<?=$routes['store'];?>>
        <input type="hidden" name="CSRF" value=<?php echo $data['csrf']; ?>>

        <div class='position-relative w-25 mx-auto'>
            <input type="login" class="form__input w-100 mb-2 border-theme p-1" 
            id="reg-form__email-input" name='login' value="<?php echo $data['user']; ?>" placeholder="логин" required>
        </div>

        <div class='position-relative w-25 mx-auto'>
            <input type="password" class="form__input w-100 mb-2 border-theme p-1" 
            id="reg-form__password1-input" name='password' placeholder="пароль (минимум 3 символа)" required>
        </div>

        <div class='position-relative w-25 mb-2 mx-auto'>
            <input type="password" class="form__input w-100 mb-2 border-theme p-1" 
            id="reg-form__password2-input" name='password_confirm' placeholder="подтвердите пароль" required>
        </div>

        <div>
            <input type="submit" class='btn w-25 mb-2 text-white bg-theme' value="Регистрация"
                   id='reg-form__reg-btn'>
            <a href=<?=$routes['home'];?> class='text-decoration-none'>
                <div class='mx-auto w-25 text-white p-2 bg-theme'>Назад</div>
            </a>
        </div>

        <p class='w-25 mx-auto fw-bolder text-danger p-2'><?php echo $data['error']; ?></p>     
    </form>
</div>
