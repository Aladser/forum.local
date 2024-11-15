class CommentClientController {
    constructor(URL, msgElement, commentList, sendCommentForm) {
        this.URL = URL;
        this.msgElement = msgElement;
        this.commentList = commentList;
        this.sendCommentForm = sendCommentForm;
        this.sendCommentForm.onsubmit = (event) => this.add(event);
        this.addRemovingListeners();
    }

    // добавить коммент - comment/store
    add(event) {
        event.preventDefault();
        // ---данные---
        let formData = new FormData(this.sendCommentForm);
        let timeNow = DBLocalTime.get();

        // ---обработка ответа от сервера---
        let process = (data) => {
            try {
                data = JSON.parse(data);
            } catch {
                this.msgElement.textContent = data;
                return;
            }

            event.target.reset();
            this.commentList.innerHTML += `
                <article class='comment-list__item border-C4C4C4 mb-2'>
                    <p class='text-start m-0 ps-2 fw-bolder'>${data.author}</p>
                    <p class='text-start m-0 py-2 ps-3 fs-5'>${data.content}</p>
                    <div class="text-end m-0 pe-2">
                        <form method="POST" action="/comment/remove/${data.id}" class="remove-comment-form d-inline-block">
                            <input type="hidden" name="CSRF" value="${data.CSRF}">
                            <input type="submit" class="comment-list__btn-remove border-0" title="Удалить" value="🗑">
                        </form>
                        <span>${timeNow}</span>
                    </div>
                </article>
            `;
            this.addRemovingListeners();
        };

        // ---запрос на сервер---
        ServerRequest.execute(
            '/comment/store',
            process,
            "post",
            this.msgElement,
            formData
        );
    }

    // удалить коммент - comment/remove/{id}
    remove(event) {
        event.preventDefault();
        // ---данные---
        let commentDOM = event.target.closest('.comment-list__item');

        // ---действия после успешного удаления данных в БД---
        let process = (data) => {
            data = JSON.parse(data);
            if (data.result == 1) {
                commentDOM.remove();
                this.msgElement.textContent = "";
            } else {
                this.msgElement.textContent = data;
            }
        };

        // запрос на сервер
        ServerRequest.execute(
            event.target.action,
            process,
            "post",
            this.msgElement,
            new FormData(event.target)
        );
    }

    /** Добавляет события удаления комментария*/
    addRemovingListeners() {
        Array.from(document.querySelectorAll('.remove-comment-form')).forEach(form => {
            form.onsubmit = event => this.remove(event);
        });
    }
}
