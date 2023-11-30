/** Фронт-контроллер таблицы 
  *
  GET|HEAD        product ...................product.index › ProductController@index
  *
  POST            product ..................product.store › ProductController@store
  *
  GET|HEAD        product/create ...........product.create › ProductController@create
  *
  GET|HEAD        product/{product} ........product.show › ProductController@show
  *
  PUT|PATCH       product/{product} ........product.update › ProductController@update
  *
  DELETE          product/{product} ........product.destroy › ProductController@destroy
  *
  GET|HEAD        product/{product}/edit ...product.edit › ProductController@edit
*/
class ArticleClientController {
    constructor(URL, table, msgElement, addForm = null, editForm = null) {
        this.URL = URL;
        this.table = table;
        this.msgElement = msgElement;
        this.addForm = addForm;
        this.editForm = editForm;

        // таблица
        if (this.table) {
            this.table
                .querySelectorAll(`.${this.table.id}__tr`)
                .forEach((row) => (row.onclick = (e) => this.clickRow(e)));

            this.table
                .querySelectorAll(".theme__btn-remove")
                .forEach((btn) => {
                    btn.onclick = (e) => this.remove(e.target.closest("tr"));
                });
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
    }

    // добавить тему в БД
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

    // обновить товар в БД
    update(event) {
        event.preventDefault();
        // ---данные---
        let product = {};
        // id
        product.id = this.editForm.getAttribute("data-id");
        // артикул
        if (this.editForm.articul) {
            product.articul = this.editForm.articul.value;
        } else {
            product.articul =
            document.querySelector(`#${this.editFormId}__articul`).textContent;
        }
        // имя
        product.name = this.editForm.name.value;
        // статус
        product.status = this.editForm.status.value;
        // атрибуты
        product.data = this.getAttributesFromForm(this.editForm);
        // ---заголовки---
        let headers = {
            "X-CSRF-TOKEN": this.csrfToken.getAttribute("content"),
            "Content-Type": "application/json",
        };
        // ---запрос на сервер---
        ServerRequest.execute(
            `${this.URL}/${product.id}`,
            (data) => this.processData(data),
            "patch",
            this.msgElement,
            JSON.stringify(product),
            headers
        );
    }

    // удалить товар в БД
    remove(row) {
        let id = row.id;
        id = id.slice(id.indexOf("-") + 1);
        // заголовки
        let headers = {
            "X-CSRF-TOKEN": this.csrfToken.getAttribute("content"),
        };
        // действия после успешного удаления данных в БД
        let process = (data) => {
            if (data.result == 1) {
                // удаление данных из клиента
                row.remove();
                this.msgElement.textContent = "";
            } else {
                this.msgElement.textContent = data;
            }
        };

        // запрос на сервер
        ServerRequest.execute(
            `${this.URL}/${id}`,
            process,
            "delete",
            this.msgElement,
            null,
            headers
        );
    }

    // обработка успешного запроса к серверу
    processData(data) {
        if (data.result == 1) {
            this.msgElement.textContent = `Товар ${data.row.articul} (${data.row.name}) ${data.type}`;
        } else {
            this.msgElement.textContent = data.description;
        }
    }

    /** получить атрибуты товара */
    getAttributesFromForm(form) {
        let data = new Map();
        let attributesElements = document.querySelectorAll(
            `.${form.id}__attribute`
        );
        if (attributesElements.length > 0) {
            attributesElements.forEach((element) => {
                let name = element.querySelector(
                    `.${form.id}__attr-name`
                ).value;
                let value = element.querySelector(
                    `.${form.id}__attr-value`
                ).value;
                if (name !== "" && value !== "") {
                    data.set(name, value);
                }
            });
        }
        return JSON.stringify(Object.fromEntries(data));
    }
}
