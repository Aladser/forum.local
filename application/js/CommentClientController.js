class CommentClientController {
    constructor(URL, msgElement, sendCommentForm) {
        this.URL = URL;
        this.msgElement = msgElement;
        this.sendCommentForm = sendCommentForm;
        this.sendCommentForm.onsubmit = (event) => this.add(event);
    }

    // добавить коммент в БД - comment/store
    add(event) {
        event.preventDefault();
        console.log(event.target);
        // ---данные---
        let formData = new FormData(this.sendCommentForm);
        // ---запрос на сервер---
        ServerRequest.execute(
            this.URL+'/store',
            (data) => {
                console.log(data);
                this.msgElement.innerHTML = data==1 ? 'статья добавлена' : data;
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
    
}
