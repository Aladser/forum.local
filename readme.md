# Простой форум статей

## Инструменты:
- php 8
- mysql
- javascript
- bootstrap

## Разворачивание
- Для запуска на сервере apache конфиг сервера */storage/forum.local.conf*
- дамп базы MySQL */storage/forum_create.sql*

## Предисловие
* В рамках проекта статьи являеются сообщениями, для которых реализуется заданный функционал;
* MVC - структура проекта;
* Для удобства в списке статей отображается автор статьи;
* не внедрена защита данных от SQL-инъекций, XSS-атак, нет SCRF-защиты для статей и комментариев.
* контроллеры:
    + ``ArticleController`` - статьи
    + ``CommentController`` - комментарии
    + ``UserController`` - пользователи
* модели:
    + ``Article`` - статьи
    + ``Comment`` - комментарии
    + ``User`` - пользователи
* самописный роутер ``Aladser\Core\Route``

## Техзадание
+ Страница регистрации
![Регистрация](/storage/images/register.png)

+ Страница входа
![Авторизация](/storage/images/login.png)

+ Пользователь просматривает список статей. Элемент списка отображается
следующим образом: заголовок сообщения и краткое содержание. Постраничный вывод сообщений. Статьи отображаются порционно по 10 статей на странице.
![список статей](/storage/images/articles.png)
+ Пользователь просматривает сообщение со списком комментариев.
+ Пользователь добавляет комментарий.
    * если авторизованный пользователь - автор статьи
![список статей](/storage/images/showmy.png)
    * другой авторизованный пользователь
![список статей](/storage/images/show.png)
+ Пользователь добавляет сообщение. Сообщение состоит из:
    * заголовок;
    * автор (скрытый input);
    * краткое содержание;
    * полное содержание.

![список статей](/storage/images/create.png)
+ Пользователь редактирует сообщение.

![список статей](/storage/images/edit.png)
