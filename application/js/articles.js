// поле ввода почты
const articleTable = document.querySelector('#table-articles');

/** Клиентский контроллер тем*/
const articleController = new ArticleClientController(
    "/article",
    articleTable ,
    document.querySelector("#table-error")
);

const articles = document.querySelectorAll('.table-articles__tr');

articles.forEach(article => {
    article.onclick = (e) => {
        // элемент какой строки нажат
        let tr = e.target.closest('tr'); 

        

        if (!tr.classList.contains('bg-secondary')) {
            tr.classList.add('bg-secondary');
            tr.classList.add('text-white');
        } else {
            tr.classList.remove('bg-secondary');
            tr.classList.remove('text-white');
        }
        console.log(tr)
    }
})