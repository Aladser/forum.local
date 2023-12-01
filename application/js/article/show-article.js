/** Клиентский контроллер тем*/
const commentController = new CommentClientController(
    "/comment",
    document.querySelector("#table-error"),
    document.querySelector("#form-send-message"),
    document.querySelector("#comment-list")
);