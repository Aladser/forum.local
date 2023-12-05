<div class='container text-center'>
    <h3 class='mt-4 mb-4 text-secondary'>Войти</h3>

    <form class='login-form' method="POST" action='' id='login-form'>
        <div class='position-relative w-25 mx-auto'>
            <input type="text" class="form__input w-100 mb-2 p-1 border-lime" id="login-form__email-input" name='login' placeholder="логин">
        </div>
        <div class='position-relative w-25 mx-auto'>
            <input type="password" class="form__input w-100 mb-2 p-1 border-lime" id="login-form__password-input" name='password'
                   placeholder="пароль">
        </div>
        <div>
            <input type="submit" class='btn w-25 mb-2 text-white bg-lime' value="Войти" disabled
                   id='login-form__login-btn'>
            <a href="/main" class='text-decoration-none'>
                <div class='mx-auto w-25 text-white p-2 bg-lime'>Назад</div>
            </a>
        </div>
        <input type="hidden" id="input-csrf" value=<?php echo $data['csrfToken']; ?>>
    </form>

    <p class='w-50 mx-auto fw-bolder text-danger d-none pt-2 mb-0' id='login-error'></p>
</div>

<script type='text/javascript' src="http://forum.local/application/js/validation.js"></script>
