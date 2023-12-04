/** Клиентский контроллер тем*/
const articleController = new ArticleClientController(
    "/article",
    document.querySelector("#prg-error"),
    null,
    document.querySelector(`#form-create-article`)
);