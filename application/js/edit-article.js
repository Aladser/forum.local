/** Клиентский контроллер тем*/
const articleController = new ArticleClientController(
    "/article",
    document.querySelector("#table-error"),
    null,
    null,
    document.querySelector(`#form-edit-article`)
);