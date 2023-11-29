// валидация почты
function validateEmail(email)
{
    return email !== '';
}

// валидация пароля
function validatePassword(password)
{
    return password.length >= 3;
}