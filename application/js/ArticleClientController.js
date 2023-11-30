class ArticleClientController {
    constructor(URL, msgElement, table = null, addForm = null, editForm = null, editBtn=null, removeBtn=null) {
        this.URL = URL;
        this.msgElement = msgElement;
        this.table = table;
        this.addForm = addForm;
        this.editForm = editForm;
        this.editBtn = editBtn;
        this.removeBtn = removeBtn;

        this.activeArticleId = false;

        // таблица
        if (this.table) {
            this.table
                .querySelectorAll(`.${this.table.id}__tr`)
                .forEach((row) => (row.onclick = (e) => this.click(e)));
        }
        // форма добавления нового товара
        if (this.addForm) {
            this.addForm.onsubmit = (event) => this.add(event);
            this.addFormId = addForm.id;
        }
        // форма изменения товара
        if (this.editForm) {
            this.editForm.onsubmit = (event) => this.update(event);
            this.editFormId = editForm.id;
        }
        // кнопка изменения
        if (this.editBtn) {
            this.editBtn.onclick = () => this.update();
        }
        // кнопка удаления
        if (this.removeBtn) {
            this.removeBtn.onclick = () => this.remove();
        }
    }

    // клик строки
    click(e) {
        // элемент какой строки нажат
        let tr = e.target.closest('tr'); 

        // активная статья
        let activeArticle = articleTable.querySelector(`.${this.table.id}__tr--active`);
        if (activeArticle !== null && activeArticle !== tr) {
            activeArticle.classList.remove('bg-secondary');
            activeArticle.classList.remove('text-white');
            activeArticle.classList.remove(`${this.table.id}__tr--active`);
        }
        
        // смена активности нажатой строки
        if (!tr.classList.contains(`${this.table.id}__tr--active`)) {
            tr.classList.add(`${this.table.id}__tr--active`);
            tr.classList.add('bg-secondary');
            tr.classList.add('text-white');
            this.editBtn.classList.remove('d-none');
            this.removeBtn.classList.remove('d-none');
            this.activeArticleId = tr.id;
            this.editBtn.href = `http://forum.local/article/edit?id=${tr.id}`; 
        } else {
            tr.classList.remove(`${this.table.id}__tr--active`);
            tr.classList.remove('bg-secondary');
            tr.classList.remove('text-white');
            this.editBtn.classList.add('d-none');
            this.removeBtn.classList.add('d-none');
            this.activeArticleId = false;
            this.editBtn.href = false; 
        }
    }

    // добавить тему в БД - article/store
    add(event) {
        event.preventDefault();
        // ---данные---
        let formData = new FormData(this.addForm);
        // ---запрос на сервер---
        ServerRequest.execute(
            this.URL+'/store',
            (data) => {
                this.msgElement.innerHTML = data==1 ? 'статья добавлена' : data;
            },
            "post",
            this.msgElement,
            formData
        );
    }

    // обновить товар в БД - article/update
    update(event) {
        event.preventDefault();
        // ---данные---
        let formData = new FormData(this.editForm);
        // ---запрос на сервер---
        ServerRequest.execute(
            this.URL+'/update',
            (data) => {
                console.log(data);
                this.msgElement.innerHTML = data==1 ? 'статья обновлена' : data;
            },
            "post",
            this.msgElement,
            formData
        );
    }

    // удалить статью в БД - article/remove
    remove() {
        let article = document.querySelector(`#${this.activeArticleId}`);
        // действия после успешного удаления данных в БД
        let process = (data) => {
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
