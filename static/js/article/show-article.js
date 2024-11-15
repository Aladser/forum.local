/** Клиентский контроллер тем*/
const commentController = new CommentClientController(
    "/comment",
    document.querySelector("#prg-error"),
    document.querySelector("#comment-list"),
    document.querySelector("#form-send-message")
);
