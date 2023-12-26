<div class='container text-center'>
    <h3 class='mt-4 mb-4 text-secondary'>Войти</h3>

    <form class='login-form' method="POST" action='/user/auth'>
        <input type="hidden" name='CSRF' value=<?php echo $data['csrfToken']; ?>>
        <div class='position-relative w-25 mx-auto'>
            <input type="text" name='login' class="form__input w-100 mb-2 p-1 border-lime" 
            placeholder="логин" value="<?php echo $data['user']; ?>" required>
        </div>
        <div class='position-relative w-25 mx-auto'>
            <input type="password" name='password' class="form__input w-100 mb-2 p-1 border-lime" placeholder="пароль"  required>
        </div>
        <div>
            <input type="submit" class='btn w-25 mb-2 text-white bg-lime' value="Войти">
            <a href="/main" class='text-decoration-none'>
                <div class='mx-auto w-25 text-white p-2 bg-lime'>Назад</div>
            </a>
        </div>
    </form>

    <?php if (isset($data['error'])) {?>
    <p class='w-50 mx-auto fw-bolder text-danger pt-2 mb-0'><?php echo $data['error']; ?></p>
    <?php }?>
</div>

<script type='text/javascript' src="http://forum.local/application/js/validation.js"></script>
