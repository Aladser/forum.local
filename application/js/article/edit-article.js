/** Клиентский контроллер тем*/
const articleController = new ArticleClientController(
    "/article",
    document.querySelector("#prg-error"),
    null,
    null,
    document.querySelector(`#form-edit-article`)
);