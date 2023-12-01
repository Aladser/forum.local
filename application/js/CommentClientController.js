class CommentClientController {
    constructor(URL, msgElement, sendCommentForm, commentList) {
        this.URL = URL;
        this.msgElement = msgElement;
        this.sendCommentForm = sendCommentForm;
        this.sendCommentForm.onsubmit = (event) => this.add(event);
        this.commentList = commentList;
    }

    // добавить коммент в БД - comment/store
    add(event) {
        event.preventDefault();
        // ---данные---
        let formData = new FormData(this.sendCommentForm);
        let timeNow = this.getTimeNow();
        // ---запрос на сервер---
        ServerRequest.execute(
            this.URL+'/store',
            (data) => {
                data = JSON.parse(data);
                if (data.result != 1) {
                    this.msgElement.innerHTML = data;
                } else {
                    event.target.reset();
                    this.commentList.innerHTML += `
                        <article class='border-C4C4C4 mb-2'>
                            <p class='text-start m-0 ps-2 fw-bolder'>${data.comment.author}</p>
                            <p class='text-start m-0 py-2 ps-3 fs-5'>${data.comment.content}</p>
                            <p class='text-end m-0 pe-2'>${timeNow}</p>
                        </article>
                    `;
                }
            },
            "post",
            this.msgElement,
            formData
        );
    }

    // удалить коммент из БД - comment/remove
    remove() {
        let article = document.querySelector(`#${this.activeArticleId}`);
        // действия после успешного удаления данных в БД
        let process = (data) => {
            console.log(data);
            data = JSON.parse(data);
            if (data.result == 1) {
                article.remove();
                this.activeArticleId = false;
                this.msgElement.textContent = "";
            } else {
                this.msgElement.textContent = data;
            }
        };

        let params = new URLSearchParams();
        params.set('id', this.activeArticleId.substring(3));

        // запрос на сервер
        ServerRequest.execute(
            this.URL + '/remove',
            process,
            "post",
            this.msgElement,
            params
        );
    }

    // текущее время
    getTimeNow() {
        let formatNumber = (number) => number < 10 ? '0'+number : number;

        let date = new Date();
        let year = date.getFullYear();
        let month = formatNumber(date.getMonth());
        let day = formatNumber(date.getDay());
        let hours = formatNumber(date.getHours());
        let minutes = formatNumber(date.getMinutes());
        let seconds = formatNumber(date.getSeconds());

        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }
}
