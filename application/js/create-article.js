/** Клиентский контроллер тем*/
const articleController = new ArticleClientController(
    "/article",
    null,
    document.querySelector("#table-error"),
    document.querySelector(`#form-create-article`)
);