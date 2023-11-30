/** Клиентский контроллер тем*/
const articleController = new ArticleClientController(
    "/article",
    document.querySelector("#table-error"),
    null,
    document.querySelector(`#form-create-article`)
);