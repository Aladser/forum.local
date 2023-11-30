// таблица статей
const articleTable = document.querySelector("#table-articles");
// поле ошибок
const errorPrg = document.querySelector("#table-error");
// кнопка редактирования строки
const editBtn = document.querySelector("#btn-edit");
// кнопка удаления строки
const removeBtn = document.querySelector("#btn-remove");

/** Клиентский контроллер тем */
const articleController = new ArticleClientController(
  "/article",
  errorPrg,
  articleTable
);
