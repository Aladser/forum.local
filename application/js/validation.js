// валидация почты
function validateEmail(email)
{
    let emailSymbols = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    return emailSymbols.test(email);
}

// валидация пароля
function validatePassword(password)
{
    return password.length >= 3;
}