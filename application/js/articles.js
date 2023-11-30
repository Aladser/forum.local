// таблица статей
const articleTable = document.querySelector("#table-articles");
// поле ошибок
const errorPrg = document.querySelector("#table-error");

// кнопка редактирования строки
const editBtn = document.querySelector("#btn-edit");
// кнопка удаления строки
const removeBtn = document.querySelector("#btn-remove");
// кнопка удаления строки
const aboutBtn = document.querySelector("#btn-about");

/** Клиентский контроллер тем */
const articleController = new ArticleClientController(
  "/article",
  errorPrg,
  articleTable,
  null,
  null,
  editBtn,
  removeBtn,
  aboutBtn
);